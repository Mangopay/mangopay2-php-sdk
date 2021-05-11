<?php

namespace MangoPay;

/**
 * Transfer entity
 */
class Transfer extends Transaction
{
    /**
     * Debited wallet Id
     * @var string
     */
    public $DebitedWalletId;

    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;
}
