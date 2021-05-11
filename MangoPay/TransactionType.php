<?php

namespace MangoPay;

final class TransactionType
{
    const PayIn = 'PAYIN';
    const Transfer = 'TRANSFER';
    const PayOut = 'PAYOUT';

    private function __construct()
    {
    }
}
