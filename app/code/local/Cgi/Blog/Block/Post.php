<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:16
 */
class Cgi_Blog_Block_Post extends Mage_Core_Block_Template
{
    public function getAllPosts()
    {
        $order  =  $this->getRequest()->getParams();
        $column = (isset($order['column']) && !empty($order['column'])) ? $order['column'] : 'date_create';
        $sort   = (isset($order['sort'])   && !empty($order['sort']))   ? $order['sort']   : 'ASC';
        return Mage::getModel('blog/post')->getListPosts($column, $sort);
    }

    public function getPost()
    {
        $post =  $this->getRequest()->getParams();
        return Mage::getModel('blog/post')->getPostById($post['id']);
    }

    public function checkPost()
    {
        return $this->getPost()->checkPostAuthor();
    }

    public function getAllProduct()
    {
        return Mage::getModel('blog/post')->getAllProduct();
    }

}