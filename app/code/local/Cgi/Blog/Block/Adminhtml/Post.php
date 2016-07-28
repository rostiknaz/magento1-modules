<?php


class Cgi_Blog_Block_Adminhtml_Post extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_post';
        $this->_headerText = Mage::helper('cgi_blog')->__('Posts - Cgi');
        parent::__construct();
        $this->_removeButton('add');
    }
    //prepare layout

}