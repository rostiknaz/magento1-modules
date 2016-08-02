<?php

/**
 * Adminhtml Price controller
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Mass action option.
     *
     * @var string
     */
    private $_option;

    /**
     * Number to action.
     *
     * @var int|float
     */
    private $_number;

    /**
     * Array of product ids.
     *
     * @var array
     */
    private $_productIds;

    /**
     * Set properties.
     */
    public function _construct()
    {
        $data              = $this->getRequest()->getParams();
        $this->_option     = $data['option'];
        $this->_number     = $data['number'];
        $productIds        = explode(',',$data['product']);
        $this->_productIds = $productIds;
    }

    /**
     * Mass action index.
     *
     * @return void
     */
    public function massPriceAction()
    {
        if ($this->_validateData()) {
            $this->_updatePrice();
        }
        $this->_redirect('*/catalog_product/index');
    }

    /**
     * Save new product prices.
     *
     * @return void
     */
    private function _updatePrice()
    {
        try {
            $productCollection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('price')
                ->addFieldToFilter('entity_id',['in' => $this->_productIds]);
            $this->_setPrice($productCollection);
            $productCollection->save();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('cgi_blog')->__(
                    'Total of %d record(s) were updated.', count($this->_productIds)
                )
            );
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }
    }

    /**
     * Set product prices.
     *
     * @return void
     */
    private function _setPrice($productCollection)
    {
        foreach($productCollection as $product){
            $old_price = $product->getPrice();
            $new_price = $this->_countNewPrice($old_price);
            $product->setPrice($new_price);
        }
    }

    /**
     * Validate data for mass action.
     *
     * @return void|bool
     */
    private function _validateData()
    {
        if (!is_array($this->_productIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cgi_updateprice')->__('Please select product(s).'));
        } else {
            if (is_numeric($this->_number) && $this->_number > 0) {
                return true;
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cgi_updateprice')->__('Number is not valid!!'));
            }
        }
    }

    /**
     * Calculate new price depending on the option.
     *
     * @param int|float $old_price Old product price.
     * @return int|float
     */
    private function _countNewPrice($old_price)
    {
        $number = $this->_number;
        switch ($this->_option){
            case 'add':
                $new_price = $old_price + $number;
                break;
            case 'substract':
                if($number > $old_price){
                    $number = 0;
                }
                $new_price = $old_price - $number;
                break;
            case 'multiple':
                $new_price = $old_price * $number;
                break;
            case 'add_percent':
                $new_price = $old_price + ($old_price * $number)/100;
                break;
            case 'substr_percent':
                $new_price = $old_price - ($old_price * $number)/100;
                break;
        }
        return $new_price;
    }
}