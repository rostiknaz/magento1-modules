<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 18.07.16
 * Time: 10:56
 */
class Cgi_Blog_Model_Resource_Post extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('blog/post', 'blogpost_id');
    }

    protected function _getLoadSelect($field, $value, $object)
    {
        $select = parent::_getLoadSelect($field, $value, $object);
        $select
            ->join(array('customer'         => 'customer_entity_varchar'), "customer.entity_id = author_id AND customer.attribute_id = 7",  array('customer.value as last_name'))
            ->join(array('customer1'        => 'customer_entity_varchar'), "customer1.entity_id = author_id AND customer1.attribute_id = 5",array('customer1.value as first_name'));
        return $select;
    }
}