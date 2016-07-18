<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 18.07.16
 * Time: 11:36
 */
class Cgi_Blog_Model_Resource_Post_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('blog/post');
    }
}