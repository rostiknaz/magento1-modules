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
        $customer = $this->getCollection()->setOrder($column, $order);
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

    public function getPostWithProductsById($id)
    {
        $post = $this->getCollection()->addFieldToFilter('product_post.blogpost_id', array('eq'=>$id));
        $post
            ->getSelect()
            ->join(array('customer' => 'customer_entity_varchar'), "customer.entity_id = author_id AND customer.attribute_id = 7", array('customer.value as last_name'))
            ->join(array('customer1' => 'customer_entity_varchar'), "customer1.entity_id = author_id AND customer1.attribute_id = 5",array('customer1.value as first_name'))
            ->join(array('product_post' => 'blog_post_product'), "product_post.blogpost_id = main_table.blogpost_id",array('product_post.product_id as product_id'))
            ->join(array('product' => 'catalog_product_entity_varchar'), "product.entity_id = product_id AND product.attribute_id = 71",array('product.value as product_name'))
            ->join(array('product1' => 'catalog_product_entity_text'), "product1.entity_id = product_id AND product1.attribute_id = 73",array('product1.value as product_short_description'))
            ->join(array('product2' => 'catalog_product_entity_decimal'), "product2.entity_id = product_id AND product2.attribute_id = 75",array('product2.value as product_price'))
            ->join(array('product3' => 'catalog_product_entity_varchar'), "product3.entity_id = product_id AND product3.attribute_id = 85",array('product3.value as product_thumbnail'));

        $posts = $post->getData();

        $result = [];
        for($i=0;$i<=count($posts);$i++){
            foreach ($posts[$i] as $key=>$value){
                if($key == 'product_name'
                    || $key == 'product_short_description'
                    || $key == 'product_price'
                    || $key == 'product_thumbnail'
                    || $key == 'product_id'
                ) {
                    $result['products'][$i][$key] = $value;
                } else {
                    $result[$key] = $value;
                }
            }
        }
//        print_r($result);
//        exit;
        return $result;
    }

    public function getPostById($id)
    {
        return $this->load($id);
    }

    public function checkPostAuthor()
    {
        return (bool) ($this->getAuthorId() == Mage::getSingleton('customer/session')->getCustomer()->getId());
    }

}