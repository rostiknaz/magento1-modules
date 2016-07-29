<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 26.07.16
 * Time: 14:58
 */
class Cgi_Blog_Model_Observer
{

    /**
     * Moved to Block class
     * @param Varien_Event_Observer $observer
     */
    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        /** @var $block Mage_Core_Block_Abstract */
        $block = $observer->getEvent()->getBlock();
        if ($block->getId() == 'sales_order_grid') {

            //add new column: payment method
            $paymentArray = Mage::getSingleton('payment/config')->getActiveMethods();
            $paymentMethods = array();
            foreach ($paymentArray as $code => $payment) {
                // not sure why ops_dl was not in the loop so tweaked it
                $paymentTitle = Mage::getStoreConfig('payment/'.$code.'/title');
                $paymentMethods[$code] = $paymentTitle;
            }
            $block->addColumnAfter(
                'payment_method',
                array(
                    'header'   => Mage::helper('sales')->__('Payment Method'),
                    'align'    => 'left',
                    'type'     => 'options',
                    'options'  => $paymentMethods,
                    'index'    => 'payment_method',
                    'filter_index'    => 'payment.method',
                ),
                'billing_name'
            );

            //add new column: shipping method
            $shippingArray = Mage::getSingleton('shipping/config')->getActiveCarriers();
            $shippingMethods = array();
            foreach ($shippingArray as $code => $shipping) {
                $shippingTitle = Mage::getStoreConfig('carriers/'.$code.'/title');
                $shippingMethods[$code] = $shippingTitle;
            }
            $block->addColumnAfter(
                'shipping_method',
                array(
                    'header'   => Mage::helper('sales')->__('Shipping Method'),
                    'align'    => 'left',
                    'type'     => 'options',
                    'options'  => $shippingMethods,
                    'index'    => 'shipping_method',
                    'filter_condition_callback' => array($this, 'shippingFilter'),
                    'renderer' => 'blog/adminhtml_renderer_shipping'
                ),
                'payment_method'
            );

            // Set the new columns order.. otherwise our column would be the last one
            $block->sortColumnsByOrder();
        }
    }

    /**
     * Moved to block class
     * @param Varien_Event_Observer $observer
     */
    public function salesOrderGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getOrderGridCollection();
        $select = $collection->getSelect();
        $select->joinLeft(array('payment' => $collection->getTable('sales/order_payment')), 'payment.parent_id=main_table.entity_id',array('payment_method' => 'method'))
                ->joinLeft(array('shipping' => $collection->getTable('sales/order')), 'shipping.entity_id=main_table.entity_id' ,array(
                    'shipping_method' => 'shipping_description',
                    'method'          => 'shipping_method'
                ));
//        print_r((string)$select);
    }

    public function shippingFilter($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue())
        {
            return $this;
        }
        $collection->getSelect()
            ->where( "shipping.shipping_method like ?", "%$value%");

        return $this;
    }
}