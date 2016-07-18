<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 14.07.16
 * Time: 18:16
 */
class Cgi_First_Block_Test extends Mage_Core_Block_Template
{

    public function welcome()
    {
        $result = Mage::getModel('first/test')->getWelcome();
        return $result;
    }
}