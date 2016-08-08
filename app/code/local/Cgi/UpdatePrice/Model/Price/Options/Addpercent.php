<?php

/**
 * Class for add percent option.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Model_Price_Options_Addpercent
    implements Cgi_UpdatePrice_Model_Price_UpdatePriceInterface
{

    public function calculatePrice($oldPrice, $number)
    {
        return $oldPrice + ($oldPrice * $number)/100;
    }
}