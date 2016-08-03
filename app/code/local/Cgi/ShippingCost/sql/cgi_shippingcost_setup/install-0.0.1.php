<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection();
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'additional_shipping_cost', array(
        'group'         => 'Education',
        'type'          => 'decimal',
        'backend'       => '',
        'frontend'      => '',
        'label'         => 'Additional shipping cost',
        'input'         => 'text',
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'       => true,
        'required'      => false,
        'user_defined'  => true,
        'visible_on_front' => false,
        'used_in_product_listing' => true,
        'apply_to' => 'simple,configurable',
        'sort_order'    => 10,
        'is_configurable' => 1
        ));

$installer->endSetup();