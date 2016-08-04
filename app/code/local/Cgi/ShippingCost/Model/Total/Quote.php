<?php

/**
 * ShippingCost Total Quote model
 *
 * @category   Cgi
 * @package    Cgi_Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_ShippingCost_Model_Total_Quote extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    private $_totalShippingCost = 0;

    public function __construct()
    {
        $this->setCode('shippingcost');
        $quote = Mage::getModel('checkout/session')->getQuote();
        $cartItems = $quote->getAllItems();

        foreach ($cartItems as $item){
            $this->_totalShippingCost += $item->getAdditionalShippingCost();
        }
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return Mage::helper('shippingcost')->__('Additional shipping');
    }

    /**
     * Collect totals information about additional shipping cost
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return Cgi_ShippingCost_Model_Total_Quote
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }
        $amount = $this->_totalShippingCost;
        if ($amount) {
            $this->_addAmount($amount);
            $this->_addBaseAmount($amount);
        }
        return $this;
    }

    /**
     * Add additional shipping cost totals information to address object
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return Cgi_ShippingCost_Model_Total_Quote
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        if (($address->getAddressType() == 'billing')) {
            $address->addTotal(array(
                'code'  => $this->getCode(),
                'title' => $this->getLabel(),
                'value' => $this->_totalShippingCost
            ));
        }

        return $this;
    }
}