<?php

namespace MangoPay;

final class TransactionNature
{
    const Regular = 'REGULAR';
    const Refund = 'REFUND';
    const Repudiation = 'REPUDIATION';
    const Settlement = 'SETTLEMENT';

    private function __construct()
    {
    }
}
