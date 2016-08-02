<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_CatalogSearch
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Validator helper
 *
 * @author
 */
class Cgi_UpdatePrice_Helper_Validator extends Mage_Core_Helper_Abstract
{
    public $error;

    public function validate($option, $number)
    {
        switch ($option){
            case Cgi_UpdatePrice_Model_Price::ADD_OPTION:
                $result = $this->_validateNumeric($number);
                break;
            case Cgi_UpdatePrice_Model_Price::SUBSTR_OPTION:
                $result = $this->_validateSubstrOption($number);
                break;
            case Cgi_UpdatePrice_Model_Price::MULTILPE_OPTION:
                $result = $this->_validateMultipleOption($number);
                break;
            case Cgi_UpdatePrice_Model_Price::ADD_PERCENT_OPTION:
                $result = $this->_validateAddPercentOption($number);
                break;
            case Cgi_UpdatePrice_Model_Price::SUBSTR_PERCENT_OPTION:
                $result = $this->_validateSubstrPercentOption($number);
                break;
        }
        return $result;
    }

//    protected function _validateAddOption($number){
//        if($this->_validateNumeric($number) &)
//        return true;
//    }

    protected function _validateSubstrOption($number){
        return true;
    }

    protected function _validateMultipleOption($number){
        return true;
    }

    protected function _validateAddPercentOption($number){
        if($this->_validateNumeric($number)){
            return true;
        } else {
            $this->error = 'Number does not valid';
            return false;
        }
    }

    protected function _validateSubstrPercentOption($number){
        return true;
    }


    public function _validateNumeric($number)
    {
        if(is_numeric($number) && $number > 0.1){
            return true;
        } else {
            $this->error = 'Number does not valid';
            return false;
        }
    }

}
