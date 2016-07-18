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
        return Mage::getModel('blog/post')->getListPosts();
    }

    public function getPost()
    {
        $params = $this->getRequest()->getParams();
        return Mage::getModel('blog/post')->getPostById($params['id']);
    }

}