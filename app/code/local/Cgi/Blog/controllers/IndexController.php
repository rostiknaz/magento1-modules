<?php

/**
 * Index controller
 *
 * @category   Cgi
 * @package    Cgi_Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_Blog_IndexController extends Mage_Core_Controller_Front_Action
{

    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->renderLayout();
    }
}