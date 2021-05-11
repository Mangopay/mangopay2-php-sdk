<?php

namespace MangoPay;

/**
 * Filtering object for PreAuthorization lists
 */
class FilterPreAuthorizations extends Libraries\Dto
{
    /**
     * @var string
     */
    public $ResultCode;

    /**
     * Status of the PreAuthorizations
     * @var string
     * @see \MangoPay\CardPreAuthorizationStatus
     */
    public $Status;

    /**
     * Status of the payment after the PreAuthorization
     * @var string
     * @see \MangoPay\CardPreAuthorizationPaymentStatus
     */
    public $PaymentStatus;
}
