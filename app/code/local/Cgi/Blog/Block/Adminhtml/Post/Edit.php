<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 27.07.16
 * Time: 15:01
 */
class Cgi_Blog_Block_Adminhtml_Post_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'blog';
        $this->_controller = 'adminhtml_post';//_form
        $this->_mode = 'edit';

//        $this->_addButton('save_and_continue', array(
//            'label' => Mage::helper('cgi_blog')->__('Save And Continue Edit'),
//            'onclick' => 'saveAndContinueEdit()',
//            'class' => 'save',
//        ), -100);
//        $this->_updateButton('save', 'label', Mage::helper('cgi_blog')->__('Save Post'));

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('form_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'edit_form');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('post_data') && Mage::registry('post_data')->getId())
        {
            return Mage::helper('cgi_blog')->__('Edit Post "%s"', $this->htmlEscape(Mage::registry('post_data')->getTitle()));
        } else {
            return Mage::helper('cgi_blog')->__('New Post');
        }
    }

}