<?php

namespace MangoPay;

/**
 * Class represents direct debit type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsDirectDebit extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Direct debit type {SOFORT, ELV, GIROPAY}
     * @var string
     */
    public $DirectDebitType;

    /**
     * Mandate Id
     * @var string
     */
    public $MandateId;

    /**
    * StatementDescriptor
    * @var string
    */
    public $StatementDescriptor;

    /**
     * ChargeDate
     * @var int
     */
    public $ChargeDate;
}
