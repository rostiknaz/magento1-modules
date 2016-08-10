<?php

/**
 * Price model.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Model_Price
{

    public $errorMessage;

    public $successMessage;

    /**
     * @var string Mass action option.
     */
    private $_option;

    /**
     * @var int|float Number to action.
     */
    private $_number;

    /**
     * @var array Array of product ids.
     */
    private $_productIds;


    public function __construct($params)
    {
        $this->_option     = $params['option'];
        $this->_number     = $params['number'];
        $this->_productIds = $params['product_ids'];
    }

    /**
     * Save new product prices.
     *
     * @return void
     */
    public function updatePrice()
    {
        $productCollection = $this->_getProductCollectionByIds($this->_productIds);
        $this->_setNewPrice($productCollection, $this->_option, $this->_number);
        if(!$this->errorMessage) {
            $productCollection->save();
            $this->successMessage = Mage::helper('cgi_updateprice')->__(
                    'Total of %d record(s) were updated.', count($this->_productIds)
                );
        }
    }

    /**
     * Get product collection by ids.
     *
     * @param array $product_ids
     * @return Mage_Catalog_Model_Resource_Product_Collection $productCollection
     */
    protected function _getProductCollectionByIds($product_ids)
    {
        $productCollection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('price')
            ->addFieldToFilter('entity_id',['in' => $product_ids]);
        return $productCollection;
    }

    /**
     * Set new product price for each collection item.
     *
     * @param object $productCollection
     * @param string $option
     * @param int|float $number
     * @return void
     */
    protected function _setNewPrice($productCollection, $option, $number)
    {
        $ids = [];
        $option = $this->_getOptionInstance($option, $number);
        foreach($productCollection as $product){
            $oldPrice = $product->getPrice();
            $newPrice = $option->calculateNewPrice($oldPrice);
            if(Mage::helper('cgi_updateprice/validator')->validate($newPrice)){
                $product->setPrice($newPrice);
            } else {
                $ids[] = $product->getId();
            }
        }
        if($ids){
            $ids = implode(',', $ids);
            $this->errorMessage = 'Products with id ' . $ids . ' has negative new price!';
        }
    }

    /**
     * Get instance of calculation class .
     *
     * @param string $option
     * @param int|float $number
     * @return Cgi_UpdatePrice_Model_Price_Calculate
     */
    protected function _getOptionInstance($option, $number)
    {
        $option = Mage::getModel('cgi_updateprice/price_calculate',[
            'option'    => $option,
            'number'    => $number
        ]);
        return $option;
    }

}