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
     * The PaymentRef must be sent on payouts that are reimbursing bank wire pay-ins and pay-ins to virtual IBANs,
     * @var PayOutPaymentRef
     */
    public $PaymentRef;

    /**
     * The parameter "PayoutModeRequested" can have different values : "STANDARD", "INSTANT_PAYMENT",
     * "INSTANT_PAYMENT_ONLY", "RTGS_PAYMENT
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
