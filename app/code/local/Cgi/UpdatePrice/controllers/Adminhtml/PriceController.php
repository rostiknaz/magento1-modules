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

    /**
     * Mass action index.
     *
     * @return void
     */
    public function massPriceAction()
    {
        $data      = $this->getRequest()->getParams();
        $validator = Mage::helper('cgi_updateprice/validator');
        if (!$validator->validate($data['number'])) {
            $this->_printErrorMessage($validator->error);
        } else {
            try {
                $priceModel = Mage::getModel('cgi_updateprice/price',[
                    'option'      => $data['option'],
                    'number'      => $data['number'],
                    'product_ids' => $data['product']
                ]);
                $priceModel->updatePrice();
                if($priceModel->errorMessage){
                    $this->_printErrorMessage($priceModel->errorMessage);
                } else {
                    $this->_printSuccessMessage($priceModel->successMessage);
                }
            } catch (Exception $e) {
                $this->_printErrorMessage($e->getMessage());
            }
        }
        $this->_redirect('*/catalog_product/index');
    }

    private function _printSuccessMessage($message)
    {
        return Mage::getSingleton('adminhtml/session')->addSuccess($message);
    }

    private function _printErrorMessage($message)
    {
        return Mage::getSingleton('adminhtml/session')->addError($message);
    }

}