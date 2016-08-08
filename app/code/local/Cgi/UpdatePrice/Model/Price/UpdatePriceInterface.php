<?php

/**
 * Declare a functions for update price mass action.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
interface Cgi_UpdatePrice_Model_Price_UpdatePriceInterface
{

    public function calculatePrice($oldPrice, $number);
}