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

    /**
     * Set properties.
     */
    public function _construct()
    {
        $data              = $this->getRequest()->getParams();
        $this->_option     = $data['option'];
        $this->_number     = $data['number'];
        $this->_productIds = explode(',',$data['product']);
    }

    /**
     * Mass action index.
     *
     * @return void
     */
    public function massPriceAction()
    {
        $validator = Mage::helper('cgi_updateprice/validator');
        if ($validator->validate($this->_option, $this->_number)) {
            Mage::getModel('cgi_updateprice/price')->updatePrice($this->_productIds, $this->_option, $this->_number);
        } else {
            Mage::getSingleton('adminhtml/session')->addError($validator->error);
        }
        $this->_redirect('*/catalog_product/index');
    }

}