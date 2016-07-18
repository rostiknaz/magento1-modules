<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:16
 */
class Cgi_Blog_Block_Post extends Mage_Core_Block_Template
{
    public function getPosts(){
        $blog = Mage::getModel('blog/post');
        return $blog->getPosts();
    }

}