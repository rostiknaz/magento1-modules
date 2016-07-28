<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 27.07.16
 * Time: 9:58
 */
class Cgi_Blog_Block_AdminHtml_Post_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('blog_grid');
        $this->setDefaultSort('blogpost_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('blog/post_collection')->addExpressionFieldToSelect(
            'fullname',
            'CONCAT({{author_firstname}}, \' \', {{author_lastname}})',
            array('author_firstname' => 'customer1.value', 'author_lastname' => 'customer.value'));
        $collection
            ->getSelect()
            ->join(array('customer' => 'customer_entity_varchar'), "customer.entity_id = author_id AND customer.attribute_id = 7",array('customer.value as last_name'))
            ->join(array('customer1' => 'customer_entity_varchar'), "customer1.entity_id = author_id AND customer1.attribute_id = 5",array('customer1.value as first_name'));

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('cgi_blog');
        $status = ['Disabled','Enabled'];
        $this->addColumn('blogpost_id', array(
            'header' => $helper->__('Post Id'),
            'index'  => 'blogpost_id'
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index'  => 'title'
        ));

        $this->addColumn('post', array(
            'header'       => $helper->__('Post'),
            'index'        => 'post',
            'renderer' => 'blog/adminhtml_renderer_trimpost'
        ));

        $this->addColumn('fullname', array(
            'header'       => $helper->__('Author'),
            'index'        => 'fullname',
            'filter_condition_callback' => array($this, '_nameFilter')
        ));

        $this->addColumn('image', array(
            'header' => $helper->__('Image'),
            'index'  => 'image',
            'width'  => '300px',
            'renderer' => 'blog/adminhtml_renderer_addimage',
        ));
        $this->addColumn('status', array(
            'header' => $helper->__('Status'),
            'align'    => 'center',
            'type'     => 'options',
            'options'  => $status,
            'index'  => 'status',
            'renderer' => 'blog/adminhtml_renderer_status',
        ));

        $this->addColumn('date_create', array(
            'header'   => $helper->__('Date Create'),
            'index'    => 'date_create',
            'type'    => 'datetime'
        ));

        $this->addExportType('*/*/exportInchooCsv', $helper->__('CSV'));
        $this->addExportType('*/*/exportInchooExcel', $helper->__('Excel XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('post_id');
        $this->getMassactionBlock()->setFormFieldName('post_id');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> Mage::helper('cgi_blog')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('' => '')),        // public function massDeleteAction() in Mage_Adminhtml_Tax_RateController
            'confirm' => Mage::helper('cgi_blog')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('cgi_blog')->__('Change status'),
            'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('cgi_blog')->__('Status'),
                    'values' => [
                        ['value'=>1,'label'=>'Enabled'],
                        ['value'=>0,'label'=>'Disabled']
                    ]
                )
            )
        ));

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _nameFilter($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue())
        {
            return $this;
        }
        $name_array = explode(' ', $value);
        for($i=0;$i<count($name_array);$i++){
            $collection->getSelect()
                ->where( "customer.value like ? OR customer1.value like ?", "%$name_array[$i]%");
        }
        return $this;
    }
}