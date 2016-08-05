<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 04.08.16
 * Time: 17:14
 */
class Cgi_ShippingCost_Block_Adminhtml_Sales_Order_InvoiceTotals extends Mage_Adminhtml_Block_Sales_Order_Invoice_Totals
{

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $amount = 0;
        $orders = $this->getOrder()->getAllItems();
        foreach($orders as $item){
            $amount += $item->getAdditionalShippingCost();
        }
        if ($amount) {
            $this->addTotalBefore(new Varien_Object(array(
                'code'      => 'shippingcost',
                'value'     => $amount,
                'base_value'=> $amount,
                'label'     => $this->helper('shippingcost')->__('Additional shipping'),
            ), array('shipping', 'tax')));
        }

        return $this;
    }
}