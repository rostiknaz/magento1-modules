<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 15.07.16
 * Time: 9:37
 */
class Cgi_First_IndexController extends Mage_Core_Controller_Front_Action
{

    public function helloAction()
    {
        $this->loadLayout();
        $this->renderLayout();
        var_dump(
            (string)   Mage::getModel('catalog/product')->getCollection()  ->addAttributeToSelect('*')->addFieldToFilter('meta_title','my title')->getSelect()
        );
    }
}