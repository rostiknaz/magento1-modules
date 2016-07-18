<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 18.07.16
 * Time: 11:01
 */
class Cgi_Blog_PostController extends Mage_Core_Controller_Front_Action
{

    public function viewAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}