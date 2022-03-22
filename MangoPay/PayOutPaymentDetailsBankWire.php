<?php

namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayOut entity
 */
class PayOutPaymentDetailsBankWire extends Libraries\Dto implements PayOutPaymentDetails
{
    /**
     * Bank account Id
     * @var string
     */
    public $BankAccountId;

    /**
     * A custom reference you wish to appear on the user’s bank statement
     * @var string
     */
    public $BankWireRef;

    /**
     * The parameter "PayoutModeRequested" can take 3 different values : "STANDARD", "INSTANT_PAYMENT", "INSTANT_PAYMENT_ONLY"
     *
     * @var string
     */
    public $PayoutModeRequested;

    /**
     * Returned ModeRequested.
     * @var string
     */
    public $ModeRequested;

    /**
     * The new parameter is the current status of the mode above.
     * @var string
     */
    public $ModeApplied;

    /**
     * The fallback reason.
     * @var FallbackReason
     */
    public $FallbackReason;

    /**
     * The status.
     * @var string
     */
    public $Status;
}
