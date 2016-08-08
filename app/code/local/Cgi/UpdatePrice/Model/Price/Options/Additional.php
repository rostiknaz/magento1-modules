<?php

/**
 * Class for additional option.
 *
 * @category   Cgi
 * @package    Cgi_UpdatePrice
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_UpdatePrice_Model_Price_Options_Additional
    implements Cgi_UpdatePrice_Model_Price_UpdatePriceInterface
{

    public function calculatePrice($oldPrice, $number)
    {
        return $oldPrice + $number;
    }
}