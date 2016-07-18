<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:24
 */
class Cgi_Blog_Model_Post extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('blog/post');
    }

    public function getListPosts()
    {
        $customer = $this->getCollection();
        $customer
            ->getSelect()
            ->join(array('customer' => 'customer_entity_varchar'), "customer.entity_id = author_id AND customer.attribute_id = 7",array('customer.value as last_name'))
            ->join(array('customer1' => 'customer_entity_varchar'), "customer1.entity_id = author_id AND customer1.attribute_id = 5",array('customer1.value as first_name'));
        return $customer;
    }

    public function getPostById($id)
    {
        return $this->load($id);
    }
}