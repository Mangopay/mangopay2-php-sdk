<?php

namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterTransactions extends FilterBase
{
    /**
     * @var string
     * @see TransactionStatus
     */
    public $Status;

    /**
     * @var string
     * @see TransactionType
     */
    public $Type;

    /**
     * @var string
     * @see TransactionNature
     */
    public $Nature;

    /**
     * @var string
     */
    public $ResultCode;
}
