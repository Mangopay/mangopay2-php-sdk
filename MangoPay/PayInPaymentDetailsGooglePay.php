<?php

namespace MangoPay;

class PayInPaymentDetailsGooglePay extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Payment information returned by Google Pay payment
     * @var \MangoPay\PaymentData
     */
    public $PaymentData;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alpha-numeric and space.
     * @var string
     */
    public $StatementDescriptor;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['PaymentData'] = '\Mangopay\PaymentData';

        return $subObjects;
    }
}
