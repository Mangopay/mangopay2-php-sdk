<?php

namespace MangoPay;

/**
 * Class represents Giropay type for mean of payment in Giropay entity
 */
class PayInPaymentDetailsGiropay extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;
}
