<?php

namespace MangoPay;

final class TransactionType
{
    public const PayIn = 'PAYIN';
    public const Transfer = 'TRANSFER';
    public const PayOut = 'PAYOUT';

    private function __construct()
    {
    }
}
