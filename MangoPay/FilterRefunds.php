<?php

namespace MangoPay;

/**
 * Filtering object for Refunds
 */
class FilterRefunds extends Libraries\Dto
{
    /**
     * Multiple values separated by commas are allowed
     * @var string
     * @see \MangoPay\RefundStatus
     */
    public $Status;

    /**
     * Multiple values separated by commas are allowed
     * @var string
     */
    public $ResultCode;
}
