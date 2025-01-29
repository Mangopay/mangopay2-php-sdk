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
    public $ReferenceId;
}
