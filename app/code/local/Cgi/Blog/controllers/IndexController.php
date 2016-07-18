<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 15.07.16
 * Time: 9:37
 */
class Cgi_Blog_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}