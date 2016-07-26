<?php

/**
 * Post controller
 *
 * @category   Cgi
 * @package    Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_Blog_PostController extends Mage_Core_Controller_Front_Action
{

    /**
     * Action for post view page.
     * Generating layout template for post view page after checking that post.
     */
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
        $checkPost = true;
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $customerData = Mage::getSingleton('customer/session');
        $data = $this->getRequest()->getParams();
        $postModel = Mage::getModel('blog/post');
        if (isset($data['post_id']) && !empty($data['post_id'])) {
            $postModel->getPostById($data['post_id']);
            $checkPost = $postModel->checkPostAuthor();
        }
        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $imageName = $this->_uploadImage($postModel);
        }
        if($checkPost && isset($data['title']) && !empty($data['title'])) {
            try {
                $postModel->setPost($data['description'])
                    ->setTitle($data['title'])
                    ->setImage($imageName)
                    ->setAuthorId($customerData->getCustomer()->getId());
                $postModel->save();
                if(!empty($data['products'])){
                    if($postModel->getProducts()->getData()){
                        $write->delete(
                            "blog_post_product",
                            "blogpost_id=" . $postModel->getId()
                        );
                    }
                    foreach ($data['products'] as $product_id){
                        $write->insert(
                            "blog_post_product",
                            array("blogpost_id" => $postModel->getId(), "product_id" => $product_id)
                        );
                    }
                }
                $customerData->addSuccess($this->__('Post has been saved!!'));
            } catch(Exception $e){
                $customerData->addException($e, $this->__($e));
            }
        } else {
            $customerData->addError($this->__('You have no permission to update this post!!!'));
        }
        $this->_redirect('blog');
    }

    public function deleteAction()
    {
        $customerData = Mage::getSingleton('customer/session');
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $data = $this->getRequest()->getParams();
        $postModel = Mage::getModel('blog/post')->getPostById($data['id']);
        if(isset($data['id']) && !empty($data['id']) && $postModel->getId()) {
            if(!$postModel->checkPostAuthor()){
                $customerData->addError($this->__('You have no permission to delete this post!!!'));
            } else {
                if($postModel->getImage()){
                    unlink(Mage::getBaseDir('media') . '/uploads/' . $postModel->getImage());
                }
                if($postModel->getProducts()){
                    $write->delete(
                        "blog_post_product",
                        "blogpost_id=" . $postModel->getId()
                    );
                }
                $postModel->delete();
                $customerData->addSuccess($this->__('Post has been deleted!!!'));
            }
        } else {
            $customerData->addError($this->__('Post with id = ' . '"' . $data['id'] . '"' . ' not found!!!'));
        }
        $this->_redirect('blog');
    }

    private function _uploadImage($postModel)
    {
        try {
            $uploader = new Varien_File_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif'));
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);

            $path       = Mage::getBaseDir('media') . '/uploads';
            $newName    = time() . $_FILES['image']['name'];
            if($postModel->getImage()){
                unlink(Mage::getBaseDir('media') . '/uploads/' . $postModel->getImage());
            }
            $uploader->save($path, $newName);
            return $newName;
        }catch(Exception $e) {
            echo "Exception: ".$e; exit;
        }
    }
}