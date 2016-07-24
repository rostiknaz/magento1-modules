<?php
$installer = $this;
$installer->startSetup();

// create table 'blog_post_product'

$table = $installer->getConnection()->newTable($installer->getTable('blog_post_product'))
    ->addColumn('blogpost_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Blogpost ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
    ), 'Product ID')
    ->setComment('Posts table');
$installer->getConnection()->createTable($table);
$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/post_product', 'blogpost_id', 'blog/post', 'blogpost_id'),
    $installer->getTable('blog/post_product'), 'blogpost_id',
    $installer->getTable('blog/post'), 'blogpost_id');
$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/post_product', 'product_id', 'blog/product', 'entity_id'),
    $installer->getTable('blog/post_product'), 'product_id',
    $installer->getTable('blog/product'), 'entity_id');

$installer->endSetup();