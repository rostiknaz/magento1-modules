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

    public function __construct()
    {
        $this->setCode('shippingcost');
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
     * Collect totals information about
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     */
    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);
        if (($address->getAddressType() == 'billing')) {
            return $this;
        }

//        $amount = INSURANCE_FEE;

//        if ($amount) {
            $this->_addAmount(100);
            $this->_addBaseAmount(100);
//        }
        return $this;
    }

    /**
     * Add giftcard totals information to address object
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     */
    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
//        print_r($address);exit;
        if (($address->getAddressType() == 'billing')) {
//            $amount = SHIPPINGCOST_FEE;
//            if ($amount != 0) {
                $address->addTotal(array(
                    'code'  => $this->getCode(),
                    'title' => $this->getLabel(),
                    'value' => 100
                ));
//            }
        }

        return $this;
    }
}