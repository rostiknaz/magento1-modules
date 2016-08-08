<?php

/**
 * Class for multiplication option.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Model_Price_Options_Multiplication
    implements Cgi_UpdatePrice_Model_Price_UpdatePriceInterface
{

    public function calculatePrice($oldPrice, $number)
    {
        return $oldPrice * $number;
    }
}