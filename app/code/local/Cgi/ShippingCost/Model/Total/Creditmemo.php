<?php

/**
 * ShippingCost Total Quote model
 *
 * @category   Cgi
 * @package    Cgi_Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_ShippingCost_Model_Total_Creditmemo extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $amount = 0;
        $orders = $creditmemo->getOrder()->getAllItems();
        foreach($orders as $item){
            $amount += $item->getAdditionalShippingCost();
        }
        if ($amount) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $amount);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $amount);
        }

        return $this;
    }
}