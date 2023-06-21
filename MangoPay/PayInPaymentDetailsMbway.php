<?php

namespace MangoPay;

class PayInPaymentDetailsMbway extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;

    /**
     * The mobile phone number of the user initiating the pay-in
     * Country code followed by hash symbol (#) followed by the rest of the number. Only digits and hash allowed
     * @var string
     */
    public $PhoneNumber;
}
