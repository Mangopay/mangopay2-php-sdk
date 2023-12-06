<?php

namespace MangoPay;

/**
 * Real time indicative market rate of a specific currency pair
 */
class ConversionRate extends Libraries\EntityBase
{
    /**
     * The sell currency – the currency of the wallet to be debited.
     * @var string
     */
    public $DebitedCurrency;

    /**
     * The buy currency – the currency of the wallet to be credited.
     * @var string
     */
    public $CreditedCurrency;

    /**
     * The market rate plus Mangopay's commission,
     * charged during the platform's billing cycle. This is an indicative rate.
     * @var string
     */
    public $ClientRate;

    /**
     * The rate used for the conversion, excluding Mangopay's commission.
     * @var string
     */
    public $MarketRate;
}
