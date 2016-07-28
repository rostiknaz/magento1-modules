<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 27.07.16
 * Time: 15:06
 */
class Cgi_Blog_Block_Adminhtml_Post_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    protected function _prepareForm()
    {
        if (Mage::getSingleton('adminhtml/session')->getPostData()) //$_SESSION = core = blog_post_data
        {
            $data = Mage::getSingleton('adminhtml/session')->getPostData();
            Mage::getSingleton('adminhtml/session')->getPostData(null);
        }
        elseif (Mage::registry('post_data'))
        {
            $data = Mage::registry('post_data')->getData();
        }
        else
        {
            $data = array();
        }

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('example_form', array(
            'legend' =>Mage::helper('cgi_blog')->__('Example Information')
        ));
        $fieldset->addField('title', 'text', array(
            'label' 	=> Mage::helper('cgi_blog')->__('Title'),
            'class' 	=> 'required-entry',
            'required'  => true,
            'name'  	=> 'title',
            'note' 	=> Mage::helper('cgi_blog')->__('The title of postS.'),
        ));

        $fieldset->addField('post', 'textarea', array(
            'label' 	=> Mage::helper('cgi_blog')->__('Post'),
            'class' 	=> 'required-entry',
            'required'  => true,
            'name'  	=> 'post',
        ));

        $form->setValues($data);

        return parent::_prepareForm();
    }


}