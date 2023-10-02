<?php

namespace MangoPay;

/**
 * PayIn payment types
 */
class PayInPaymentType
{
    const BankWire = 'BANK_WIRE';
    const Card = 'CARD';
    const DirectDebit = 'DIRECT_DEBIT';
    const DirectDebitDirect = 'DIRECT_DEBIT_DIRECT';
    const Preauthorized = 'PREAUTHORIZED';
    const PayPal = 'PAYPAL';
    const ApplePay = 'APPLEPAY';
    const GooglePay = 'GOOGLEPAY';
    const GooglePayV2 = 'GOOGLE_PAY';
    const Payconiq = 'PAYCONIQ';
    const Mbway = 'MBWAY';
    const Multibanco = 'MULTIBANCO';
    const Satispay = 'SATISPAY';
    const Blik = 'BLIK';
    const Klarna = 'KLARNA';
    const Ideal = 'IDEAL';
    const Giropay = 'GIROPAY';
}
