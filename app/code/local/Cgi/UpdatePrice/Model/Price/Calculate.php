<?php

/**
 * Created by PhpStorm.
 * User: naro
 * Date: 08.08.16
 * Time: 10:13
 */
class Cgi_UpdatePrice_Model_Price_Calculate
{
    private $_optionInstance;

    /**
     * @var int|float Number to action.
     */
    private $_number;

    public function __construct($params)
    {
        $operations = Mage::app()->getConfig()->getNode('global/price_mass_action/operations');
        $className = $operations->$params['option']->class;
        $this->_optionInstance = Mage::getModel($className);
        $this->_number     = $params['number'];
    }

    public function calculateNewPrice($oldPrice)
    {
        if(is_object($this->_optionInstance)){
            return $this->_optionInstance->calculatePrice($oldPrice, $this->_number);
        }
    }
}