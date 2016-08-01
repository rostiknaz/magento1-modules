<?php

/**
 * Top3product widget helper
 *
 * @category   Cgi
 * @package    Cgi_Blog
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_TopWidget_Block_Top3product
    extends Mage_Core_Block_Template
    implements Mage_Widget_Block_Interface
{
    protected $_productCount = 3;

    protected $_title        = '';

    protected function _construct()
    {
        $widget     = Mage::helper('topwidget')->getTopWidgetInstance();
        $parameters = unserialize($widget['widget_parameters']);
        $this->_productCount = $parameters['product_count'];
        $this->_title        = $parameters['title'];
        parent::_construct();
    }


    public function getTopProducts()
    {
        $collection = Mage::getModel('catalog/product')
            ->getCollection()
            ->addAttributeToSelect(['id', 'name', 'thumbnail','url_path'])
            ->addFieldToFilter('is_top', ['eq'=>'1'])
            ->setPageSize($this->_productCount);
        $collection->getSelect()->order('RAND()');
        return $collection;
    }
}