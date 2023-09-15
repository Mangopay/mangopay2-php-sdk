<?php

namespace MangoPay;

class PayInPaymentDetailsSatispay extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;

    /**
     * The end-user country of residence
     * @var string
     */
    public $Country;
}
