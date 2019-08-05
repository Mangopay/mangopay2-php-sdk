<?php

namespace MangoPay;

/**
 * Apple Pay-in entity
 */
class PayInApple extends Transaction
{

    /**
     * Payment information returned by Apple Pay payment
     * @var \MangoPay\PaymentData
     */
    public $PaymentData;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alpha-numeric and space.
     * @var string
     */
    public $StatementDescriptor;

    public function GetDependsObjects()
    {
        return array(
            'PaymentData' => '\MangoPay\PaymentData'
        );
    }

}