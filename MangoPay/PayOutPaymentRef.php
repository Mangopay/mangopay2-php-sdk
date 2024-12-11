<?php

namespace MangoPay;

class PayOutPaymentRef extends Libraries\Dto
{
    /**
     * ReasonType (PAYIN_REFUND)
     * @var string
     */
    public $ReasonType;

    /**
     * @var string
     */
    public $referenceId;
}

/**
 * Reason for PayOut
 */
class PayoutReasonType
{
    const PayInRefund = 'PAYIN_REFUND';
}