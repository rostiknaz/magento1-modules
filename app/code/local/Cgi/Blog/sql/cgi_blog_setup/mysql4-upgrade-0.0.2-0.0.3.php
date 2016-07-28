<?php
$installer = $this;
$installer->startSetup();


$installer->getConnection()
    ->addColumn($installer->getTable('blog/post'),'status', array(
        'type'      => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
        'default' => 1,
        'comment' => 'Status'
    ));
$installer->endSetup();