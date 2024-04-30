<?php

namespace MangoPay;

class PayInRecurringRegistration extends Libraries\Dto
{
    /**
     * @var string
     */
    public $Id;

    /**
     * @var string
     */
    public $AuthorId;

    /**
     * @var string
     */
    public $CardId;

    /**
     * @var string
     */
    public $CreditedUserId;

    /**
     * @var string
     */
    public $CreditedWalletId;

    /**
     * @var \MangoPay\Money
     */
    public $FirstTransactionDebitedFunds;

    /**
     * @var \MangoPay\Money
     */
    public $FirstTransactionFees;

    /**
     * @var \MangoPay\Billing
     */
    public $Billing;

    /**
     * @var \MangoPay\Shipping
     */
    public $Shipping;

    /**
     * @var int Unix timestamp
     */
    public $EndDate;

    /**
     * @var string
     */
    public $Frequency;

    /**
     * @var bool
     */
    public $FixedNextAmount;

    /**
     * @var bool
     */
    public $FractionedPayment;

    /**
     * @var bool
     */
    public $Migration;

    /**
     * @var \MangoPay\Money
     */
    public $NextTransactionDebitedFunds;

    /**
     * @var \MangoPay\Money
     */
    public $NextTransactionFees;

    /**
     * @var string
     */
    public $Status;

    /**
     * @var int
     */
    public $FreeCycles;

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        return [ 'Id' ];
    }
}
