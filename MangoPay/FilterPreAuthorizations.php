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
     * {CREATED, SUCCEEDED, FAILED}
     * @var string
     */
    public $Status;

    /**
     * Status of the payment after the PreAuthorization
     * {WAITING, CANCELED, EXPIRED, VALIDATED}
     * @var string
     */
    public $PaymentStatus;
}