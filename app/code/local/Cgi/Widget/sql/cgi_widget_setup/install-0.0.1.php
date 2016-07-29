<?php
$installer = $this;
$installer->startSetup();
$installer->getConnection();
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'is_top', array(
        'group'         => 'Education',
        'type'          => 'int',
        'backend'       => '',
        'frontend'      => '',
        'label'         => 'Is Top',
        'input'         => 'select',
        'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'backend'       => 'eav/entity_attribute_backend_array',
        'visible'       => true,
        'required'      => false,
        'user_defined'  => true,
        'default'       => '0',
        'visible_on_front' => false,
        'used_in_product_listing' => true,
        'apply_to' => 'simple,configurable',
        'sort_order'    => 10,
        'is_configurable' => 1,
        'option'     => array (
            'values' => array(
                0 => 'No',
                1 => 'Yes',
            )
        )));
$installer->endSetup();