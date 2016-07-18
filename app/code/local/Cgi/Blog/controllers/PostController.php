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

    public function createAction()
    {
        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_redirect('customer/account/login');
        }
    }

    public function updateAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction()
    {
        $data = $this->getRequest()->getParams();
        $customerData = Mage::getSingleton('customer/session');
        $post = Mage::getModel('blog/post')
            ->setPost($data['description'])
            ->setTitle($data['title'])
            ->setAuthorId($customerData->getCustomer()->getId());
        $post->save();
//        print_r($post);
        $customerData->addSuccess($this->__('The alert subscription has been saved.'));
    }
}