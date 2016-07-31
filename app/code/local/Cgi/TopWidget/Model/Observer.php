<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 26.07.16
 * Time: 14:58
 */
class Cgi_TopWidget_Model_Observer
{

    /**
     * Moved to Block class
     *
     * @param Varien_Event_Observer $observer
     */
    public function coreBlockAbstractToHtmlBefore(Varien_Event_Observer $observer)
    {
        /** @var $block Mage_Core_Block_Abstract */
        $block = $observer->getEvent()->getBlock();
        if (!isset($block)) return $this;
        if ($block->getType() == 'adminhtml/catalog_product_grid') {

            //add new column: is top
            $options = ['No','Yes'];
            $block->addColumnAfter(
                'is_top',
                array(
                    'header'   => Mage::helper('topwidget')->__('Is Top'),
                    'type'     => 'options',
                    'options'  => $options,
                    'index'    => 'is_top',
//                    'renderer' => 'widget/adminhtml_renderer_toplabel'
                ),
                'type'
            );

            // Set the new columns order.. otherwise our column would be the last one
            $block->sortColumnsByOrder();
        }
    }

    /**
     * Moved to block class
     * @param Varien_Event_Observer $observer
     */
    public function catalogProductGridCollectionLoadBefore(Varien_Event_Observer $observer)
    {
        $collection = $observer->getCollection();
        if (!isset($collection)) {
            return $collection;
        }

        $collection
            ->addAttributeToSelect('is_top');

        $observer->setCollection($collection);
//        print_r((string)$collection->getSelect());exit;
    }

}