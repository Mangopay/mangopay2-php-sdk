<?php

namespace MangoPay;

use MangoPay\Libraries\EntityBase;

class ConversionQuote extends EntityBase
{
    /**
     * Expiration date
     * @var int
     */
    public $ExpirationDate;

    /**
     * @var string
     * @see TransactionStatus
     */
    public $Status;

    /**
     * The time in seconds during which the quote is active and can be used for conversions.
     * @var int
     */
    public $Duration;

    /**
     * Debited funds
     * @var Money
     */
    public $DebitedFunds;

    /**
     * Credited funds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * @var ConversionRate
     */
    public $ConversionRateResponse;
}
