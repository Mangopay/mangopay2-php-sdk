<?php
namespace MangoPay;

/**
 * Class represents direct debit type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsDirectDebitDirect extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Mandate identifier.
     * @var string
     */
    public $MandateId;

	 /**
     * StatementDescriptor
     * @var string
     */
     public $StatementDescriptor;
}
