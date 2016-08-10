<?php

/**
 * Class for creating instance of option and calculate new price.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
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