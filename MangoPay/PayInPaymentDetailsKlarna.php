<?php

namespace MangoPay;

/**
 * Class represents Klarna type for mean of payment in Klarna entity
 */
class PayInPaymentDetailsKlarna extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Information about the order items (basket)
     * Note : The LineItems total amount must match the declared DebitedFunds
     * @var array
     */
    public $LineItems;

    /**
     * The end-user residency country
     * @var string
     */
    public $Country;

    /**
     * The language in which the Klarna payment page is to be displayed - Alpha-2  format (default US)
     * @var string
     */
    public $Culture;

    /**
     * The end-user mobile phone number
     * @var string
     */
    public $Phone;

    /**
     * The end-user email address
     * @var string
     */
    public $Email;

    /**
     * Klarna custom data that you can add to this item
     * @var string
     */
    public $AdditionalData;

    /**
     * Information about the shipping address
     * @var Shipping
     */
    public $Shipping;

    /**
     * The Klarna option that the end-user has chosen at checkout
     * @var string
     */
    public $PaymentMethod;

    /**
     * The merchant order reference
     * @var string
     */
    public $Reference;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Shipping'] = '\MangoPay\Shipping';

        return $subObjects;
    }
}
