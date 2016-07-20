<?php
$installer = $this;
$installer->startSetup();
$table = $installer->getConnection()->newTable($installer->getTable('blog_posts'))
    ->addColumn('blogpost_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true,
    ), 'Blogpost ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default' => '',
    ), 'Title')
    ->addColumn('post', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
        'nullable' => false,
        'default' => '',
    ), 'Post')
    ->addColumn('date_create', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT,
    ), 'Date create')
    ->addColumn('date_update', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable' => true,
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_UPDATE
    ), 'Date update')
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable' => false,
        'default' => '',
    ), 'Image')
    ->addColumn('author_id', Varien_Db_Ddl_Table::TYPE_INTEGER, 11, array(
        'nullable' => false,
    ), 'Author ID')
    ->setComment('Posts table');
$installer->getConnection()->createTable($table);
$installer->getConnection()->addForeignKey(
    $installer->getFkName('blog/post', 'author_id', 'blog/customer', 'entity_id'),
    $installer->getTable('blog/post'), 'author_id',
    $installer->getTable('blog/customer'), 'entity_id');
$installer->endSetup();