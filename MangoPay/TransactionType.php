<?php

namespace MangoPay;

final class TransactionType
{
    const PayIn = 'PAYIN';
    const Transfer = 'TRANSFER';
    const PayOut = 'PAYOUT';
    const CardValidation = 'CARD_VALIDATION';
    const Conversion = 'CONVERSION';

    private function __construct()
    {
    }
}
