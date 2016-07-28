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

    public function getListPosts($column = 'date_create', $order = 'DESC')
    {
        $customer = $this->getCollection()
            ->addFieldToFilter('status', array('eq'=>1))
            ->setOrder($column, $order);
        $customer
            ->getSelect()
            ->join(array('customer' => 'customer_entity_varchar'), "customer.entity_id = author_id AND customer.attribute_id = 7",array('customer.value as last_name'))
            ->join(array('customer1' => 'customer_entity_varchar'), "customer1.entity_id = author_id AND customer1.attribute_id = 5",array('customer1.value as first_name'));
        return [
            'posts' => $customer,
            'column'   => $column,
            'order'    => $order
        ];
    }

    public function getPostById($id)
    {
        return $this->load($id);
    }

    public function getProducts()
    {
        $products = Mage::getModel('catalog/product')->getCollection()->addAttributeToSelect(['id', 'name', 'short_description', 'thumbnail', 'small_image', 'url_path', 'price','special_price']);
        $products
            ->getSelect()
            ->join(array('product_post' => 'blog_post_product'), "product_post.product_id = entity_id",array('product_post.product_id as product_id'))
            ->where('product_post.blogpost_id = ' . $this->getId());
        return $products;
    }

    public function getAllProduct()
    {
        $products = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect('name','id');
        return $products;
    }

    public function checkPostAuthor()
    {
        return (bool) ($this->getAuthorId() == Mage::getSingleton('customer/session')->getCustomer()->getId());
    }

}