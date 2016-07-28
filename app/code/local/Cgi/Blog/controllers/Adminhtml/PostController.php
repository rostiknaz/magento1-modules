<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 27.07.16
 * Time: 9:47
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
        $param =  $this->getRequest()->getParams('id');
        $post = Mage::getModel('blog/post')->getPostById($param['id']);
        Mage::register('post_data', $post);
        $this->_title($this->__('Blog'))->_title($this->__('Post'))->_title($this->__('Edit'));
        $this->loadLayout();
        $this->_setActiveMenu('cgi_blog');
        $this->_addContent($this->getLayout()->createBlock('blog/adminhtml_post_edit'));
        $this->renderLayout();
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
}