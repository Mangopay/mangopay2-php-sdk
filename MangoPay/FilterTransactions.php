<?php

namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterTransactions extends FilterBase
{
    /**
     * @var string
     * @see \MangoPay\TransactionStatus
     */
    public $Status;

    /**
     * @var string
     * @see \MangoPay\TransactionType
     */
    public $Type;

    /**
     * @var string
     * @see \MangoPay\TransactionNature
     */
    public $Nature;

    /**
     * @var string
     */
    public $ResultCode;

    /**
     * @var string
     * Possible values: USER_PRESENT, USER_NOT_PRESENT.
     *
     * In case USER_PRESENT is used and SCA is required, an error containing the RedirectUrl will be thrown
     */
    public $ScaContext;
}
