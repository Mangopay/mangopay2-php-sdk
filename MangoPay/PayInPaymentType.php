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
    const Preauthorized = 'PREAUTHORIZED';
	const PayPal = 'PAYPAL';
}
