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
        if (Mage::registry('post_data') && Mage::registry('all_products')) {
            $post = Mage::registry('post_data');
            $allProducts = Mage::registry('all_products');
        } else {
            $post = array();
            $allProducts = array();
        }
        $post_products = $post->getProducts();
        $product_ids = [];
        foreach($post_products as $product){
            $product_ids[] = $product->getId();
        }
//        print_r($product_ids);

        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
        ));

        $form->setUseContainer(true);

        $this->setForm($form);

        $fieldset = $form->addFieldset('edit_form', array(
            'legend' =>Mage::helper('cgi_blog')->__('Edit post')
        ));
        $fieldset->addField('title', 'text', array(
            'label' 	=> Mage::helper('cgi_blog')->__('Title'),
            'class' 	=> 'required-entry',
            'required'  => true,
            'style'     => 'width:500px',
            'name'  	=> 'title',
            'note' 	    => Mage::helper('cgi_blog')->__('The title of post.'),
        ));

        $fieldset->addField('post', 'textarea', array(
            'label' 	=> Mage::helper('cgi_blog')->__('Post'),
            'class' 	=> 'required-entry',
            'style'     => 'width:500px',
            'required'  => true,
            'name'  	=> 'post',
        ));

        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => Mage::helper('cgi_blog')->__('Image'),
        ));
        $fieldset->addField('products', 'multiselect', array(
            'label'     => Mage::helper('cgi_blog')->__('Select Product'),
            'name'      => 'products',
            'values'    => $this->_getOptionArray($allProducts),
            'value'     => $product_ids,
        ));

        $form->setValues($post);

        return parent::_prepareForm();
    }

    protected function _getOptionArray($products_collection)
    {
        $select_data = [];
        foreach($products_collection as $product){
            $select_data[] = [
                'value' => $product->getId(),
                'label' =>  $product->getName()
            ];
        }
        return $select_data;
    }


}