<?php



class Cgi_TopWidget_Block_Top3product
    extends Mage_Core_Block_Abstract
    implements Mage_Widget_Block_Interface
{

    protected function _construct()
    {
        parent::_construct(); // TODO: Change the autogenerated stub
//        $this->setLayout($this->getData('template'));
    }

    /**
  * Produce links list rendered as html
  *
  * @return string
  */
  public function _toHtml() {
    $html = 'Hello';


    return Mage::getSingleton('core/layout')->createBlock('core/template')->setTemplate($this->getData('template'))->toHtml();
  }
}