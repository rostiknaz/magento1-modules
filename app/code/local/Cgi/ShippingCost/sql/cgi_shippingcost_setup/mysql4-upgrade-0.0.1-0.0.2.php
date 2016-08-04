<?php
$installer = new Mage_Sales_Model_Resource_Setup('core_setup');
/**
 * Add 'additional_shipping_cost' attribute for entities
 */
$entities = array(
    'quote_item',
    'order_item'
);
$options = array(
    'type'     => Varien_Db_Ddl_Table::TYPE_DECIMAL,
    'visible'  => true,
    'required' => false
);
foreach ($entities as $entity) {
    $installer->addAttribute($entity, 'additional_shipping_cost', $options);
}
$installer->endSetup();