<?php

/**
 * Adminhtml Price controller
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Adminhtml_PriceController extends Mage_Adminhtml_Controller_Action
{

    public function massPriceAction()
    {
        $data = $this->getRequest()->getParams();
        if (!is_array($data)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cgi_updateprice')->__('Please select product(s).'));
        } else {
            if(is_numeric($data['number']) && $data['number'] > 0) {
                try {
                foreach ($data['product'] as $productId) {
                    $productModel   = Mage::getModel('catalog/product')->load($productId);
                    $old_price      = $productModel->getPrice();
                    $price_percent  = ($old_price * $data['number'])/100;
                    switch ($data['option']){
                        case 'add':
                            $new_price = $old_price + $data['number'];
                            break;
                        case 'substract':
                            if($data['number'] > $old_price){
                                $data['number'] = 0;
                            }
                            $new_price = $old_price - $data['number'];
                            break;
                        case 'multiple':
                            $new_price = $old_price * $data['number'];
                            break;
                        case 'add_percent':
                            $new_price = $old_price + $price_percent;
                            break;
                        case 'substr_percent':
                            $new_price = $old_price - $price_percent;
                            break;
                    }
                    $productModel
                        ->setPrice($new_price)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('cgi_blog')->__(
                        'Total of %d record(s) were updated.', count($data['product'])
                    )
                );
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            } else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cgi_updateprice')->__('Number is not valid!!'));
            }
        }
        $this->_redirect('*/catalog_product/index');
    }
}