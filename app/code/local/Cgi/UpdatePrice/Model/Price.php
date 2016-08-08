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

    protected function _getProductCollectionByIds($product_ids)
    {
        $productCollection = Mage::getResourceModel('catalog/product_collection')
            ->addAttributeToSelect('price')
            ->addFieldToFilter('entity_id',['in' => $product_ids]);
        return $productCollection;
    }

    /**
     * Set product prices.
     *
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

    protected function _getOptionInstance($option, $number)
    {
        $option = Mage::getModel('cgi_updateprice/price_calculate',[
            'option'    => $option,
            'number'    => $number
        ]);
        return $option;
    }

}