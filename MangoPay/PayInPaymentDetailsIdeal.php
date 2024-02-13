<?php

namespace MangoPay;

/**
 * Class represents IDEAL type for mean of payment in IDEAL entity
 */
class PayInPaymentDetailsIdeal extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The BIC identifier of the end-user’s bank
     * @var string
     */
    public $Bic;

    /**
     * Name of the end-user’s bank
     * @var string
     */
    public $BankName;


    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;
}
