<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:16
 */
class Cgi_ShippingCost_Block_AddShippingTotals extends Mage_Core_Block_Template
{

    public function initTotals()
    {
        $amount = 0;
        $orders = $this->getParentBlock()->getOrder()->getAllItems();
        foreach($orders as $item){
            $amount += $item->getAdditionalShippingCost();
        }

        if ($amount) {
            $this->getParentBlock()->addTotalBefore(new Varien_Object(array(
                'code'      => 'shippingcost',
                'value'     => $amount,
                'base_value'=> $amount,
                'label'     => $this->helper('shippingcost')->__('Additional shipping'),
            ), array('shipping', 'tax')));
        }
        return $this;
    }
}