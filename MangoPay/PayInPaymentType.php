<?php

namespace MangoPay;

/**
 * PayIn payment types
 */
class PayInPaymentType
{
    public const BankWire = 'BANK_WIRE';
    public const Card = 'CARD';
    public const DirectDebit = 'DIRECT_DEBIT';
    public const DirectDebitDirect = 'DIRECT_DEBIT_DIRECT';
    public const Preauthorized = 'PREAUTHORIZED';
    public const PayPal = 'PAYPAL';
    public const ApplePay = 'APPLEPAY';
    public const GooglePay = 'GOOGLEPAY';
}
