<?php

namespace MangoPay;

/**
 * Class represents PayPal type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsPaypal extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Address used instead of the user's PayPal account address.
     * @var ShippingAddress
     * @deprecated This property will be removed in the future due to the introduction of a new way to create PayPal PayIns
     */
    public $ShippingAddress;

    /**
     * PayPal buyer's email account
     * @var string
     * @deprecated This property will be removed in the future due to the introduction of a new way to create PayPal PayIns
     */
    public $PaypalBuyerAccountEmail;



    /// V2 ///

    /**
     * The URL where users are automatically redirected after the payment is validated
     * @var string
     */
    public $ReturnURL;

    /**
     * The URL to which the user is redirected to complete the payment
     * @var string
     */
    public $RedirectURL;

    /**
     * Custom description of the payment shown to the consumer when making payments and on the bank statement
     * @var string
     */
    public $StatementDescriptor;

    /**
     * User’s shipping address When not provided, the default address is the one register one the buyer PayPal account
     * @var Shipping
     */
    public $Shipping;

    /**
     * Information about the items bought by the customer
     * @var array
     */
    public $LineItems;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ShippingAddress'] = '\MangoPay\ShippingAddress';
        $subObjects['Shipping'] = '\MangoPay\Shipping';

        return $subObjects;
    }
}
