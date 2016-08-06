<?php

/**
 * ShippingCost observer
 *
 * @category   Cgi
 * @package    Cgi_ShippingCost
 * @author     Nazymko Rostyslav CGI Trainee group beta
 */
class Cgi_ShippingCost_Model_Observer
{

    public function salesQuoteItemSetAdditionalShippingCost($observer)
    {
        $quoteItem = $observer->getQuoteItem();
        $product = $observer->getProduct();
        if($quoteItem->getParentItemId() == NULL) {
            $quoteItem->setAdditionalShippingCost($product->getAdditionalShippingCost());
        }
    }

}