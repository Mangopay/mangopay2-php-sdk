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
}
