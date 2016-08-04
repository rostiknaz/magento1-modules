<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 04.08.16
 * Time: 17:14
 */
class Cgi_ShippingCost_Block_Adminhtml_Sales_Order_Totals extends Mage_Adminhtml_Block_Sales_Order_Totals
{

    /**
     * Initialize order totals array
     *
     * @return Mage_Sales_Block_Order_Totals
     */
    protected function _initTotals()
    {
        parent::_initTotals();
        $order_id = $this->getRequest()->getParam('order_id');
        $order = Mage::getModel('sales/order_item')
            ->getCollection()
            ->addFieldToSelect('additional_shipping_cost')
            ->addFieldToFilter('order_id',['eq'=>$order_id]);
        print_r($order->getData());
        $amount = 5;
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