<?php
namespace MangoPay;

/**
 * Filtering object for Refunds
 */
class FilterRefunds extends Libraries\Dto
{

    /**
     * TransactionStatus {CREATED, SUCCEEDED, FAILED}
     * Multiple values separated by commas are allowed
     * @var string
     */
    public $Status;

    /**
     * The result code of the transaction
     * Multiple values separated by commas are allowed
     * @var string
     */
    public $ResultCode;
}