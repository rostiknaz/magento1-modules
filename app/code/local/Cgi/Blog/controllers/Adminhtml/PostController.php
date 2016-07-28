<?php

/**
 * Adminhtml Post controller
 *
 * @category   Cgi
 * @package    Cgi_Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_Blog_Adminhtml_PostController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_title($this->__('Blog'))->_title($this->__('Posts'));
        $this->loadLayout();
        $this->_setActiveMenu('cgi_blog');
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_post'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('blog/adminhtml_post_grid')->toHtml()
        );
    }


    public function newAction()
    {
        $this->_forward('edit');
    }

    public function editAction()
    {
        $param       =  $this->getRequest()->getParams('id');
        $post        = Mage::getModel('blog/post')->getPostById($param['id']);
        $allProducts = Mage::getModel('blog/post')->getAllProduct();
        Mage::register('post_data', $post);
        Mage::register('all_products', $allProducts);
        $this->_title($this->__('Blog'))->_title($this->__('Post'))->_title($this->__('Edit'));
        $this->loadLayout();
        $this->_setActiveMenu('cgi_blog');
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_post_edit'));
        $this->renderLayout();
    }

    public function saveAction()
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $customerData = Mage::getSingleton('customer/session');
        $data = $this->getRequest()->getParams();
        $postModel = Mage::getModel('blog/post')->getPostById($data['id']);
//        print_r($data);exit;
        $imageName = '';
        if(isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
            $imageName = Mage::helper('cgi_blog')->uploadImage($postModel);
        }
        $newImageName = ($imageName == '') ? $imageName : 'uploads/' . $imageName;
        if(isset($data['image']['delete']) && empty($_FILES['image']['name'])){
            unlink(Mage::getBaseDir('media') . '/' . $postModel->getImage());
            $postModel->setImage('');
        }

        try {
            $postModel->setPost($data['post'])->setTitle($data['title']);
            if($newImageName != ''){
                $postModel->setImage($newImageName);
            }
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
        } catch(Exception $e){
            $customerData->addException($e, $this->__($e));
        }

        $this->_redirect('adminhtml/post');
    }

    public function deleteAction()
    {
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        $data = $this->getRequest()->getParams();
        $postModel = Mage::getModel('blog/post')->getPostById($data['id']);
        if($postModel->getImage()){
            unlink(Mage::getBaseDir('media') . '/' . $postModel->getImage());
        }
        if($postModel->getProducts()){
            $write->delete(
                "blog_post_product",
                "blogpost_id=" . $postModel->getId()
            );
        }
        $postModel->delete();
        $this->_redirect('adminhtml/post');
    }

    public function exportInchooCsvAction()
    {
        $fileName = 'posts_cgi.csv';
        $grid = $this->getLayout()->createBlock('blog/adminhtml_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    public function exportInchooExcelAction()
    {
        $fileName = 'posts_cgi.xml';
        $grid = $this->getLayout()->createBlock('blog/adminhtml_post_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

    public function massStatusAction()
    {
        $data = $this->getRequest()->getParams();
        if(!is_array($data)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('tax')->__('Please select post(s).'));
        } else {
            try {
                $postModel = Mage::getModel('blog/post');
                foreach ($data['post_id'] as $postId) {
                    $postModel->load($postId)
                        ->setStatus($data['status'])
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cgi_blog')->__(
                        'Total of %d record(s) were updated.', count($data['post_id'])
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}