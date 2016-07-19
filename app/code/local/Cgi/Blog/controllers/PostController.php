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
        $session = Mage::getSingleton('customer/session');
        $param =  $this->getRequest()->getParams('id');
        $post = Mage::getModel('blog/post')->getPostById($param['id']);
        if(!empty($param['id']) && $post->getId()) {
            $this->loadLayout();
            $this->getLayout()->getBlock('head')->setTitle($this->__($post->getTitle()));
            $this->renderLayout();
        } else {
            $this->_redirect('blog');
            $session->addError($this->__('Post with id = ' . '"' . $param['id'] . '"' . ' not found!!!'));
        }
    }

    public function createAction()
    {
        $session = Mage::getSingleton('customer/session');
        if($session->isLoggedIn()) {
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_redirect('customer/account/login');
            $session->addError($this->__('You are not logged in!!'));
        }
    }

    public function updateAction()
    {
        $customerData = Mage::getSingleton('customer/session');
        $param =  $this->getRequest()->getParams('id');
        $post = Mage::getModel('blog/post')->getPostById($param['id']);
        if($post->checkPostAuthor()) {
            $this->viewAction();
        } else {
            $customerData->addError($this->__('You have no permission to edit this post!!!'));
            $this->_redirect('blog');
        }
    }

    public function saveAction()
    {
        $customerData = Mage::getSingleton('customer/session');
        $data = $this->getRequest()->getParams();
        if(isset($_FILES['image']['name'])) {
            try {
                $uploader = new Varien_File_Uploader('image');
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                $path       = Mage::getBaseDir('media') . '/uploads';
                $newName    = time() . $_FILES['image']['name'];
                $uploader->save($path, $newName);
            }catch(Exception $e) {
                echo "Exception: ".$e; exit;
            }
        }
        try {
            $postModel = Mage::getModel('blog/post');
            if (isset($data['post_id']) && !empty($data['post_id'])) {
                $postModel->load($data['post_id']);
            }
            $postModel->setPost($data['description'])
                ->setTitle($data['title'])
                ->setImage($newName)
                ->setAuthorId($customerData->getCustomer()->getId());
            $postModel->save();
            $customerData->addSuccess($this->__('Post has been saved!!'));
            $this->_redirect('blog');
        } catch(Exception $e){
            $customerData->addException($e, $this->__('Unable to update or create the alert subscription.'));
        }
    }

    public function deleteAction()
    {
        $customerData = Mage::getSingleton('customer/session');
        $data = $this->getRequest()->getParams();
        $postModel = Mage::getModel('blog/post')->getPostById($data['id']);
        if(isset($data['id']) && !empty($data['id']) && $postModel->getId()) {
            if(!$postModel->checkPostAuthor()){
                $customerData->addError($this->__('You have no permission to delete this post!!!'));
            } else {
                $postModel->load($data['id'])
                    ->delete();
                $customerData->addSuccess($this->__('Post has been deleted!!!'));
            }
        } else {
            $customerData->addError($this->__('Post with id = ' . '"' . $data['id'] . '"' . ' not found!!!'));
        }
        $this->_redirect('blog');
    }
}