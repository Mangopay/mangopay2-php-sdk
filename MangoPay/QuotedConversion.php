<?php

namespace MangoPay;

/**
 * A conversion, at the rate guaranteed by its quote, of the debited funds to the credited wallet.
 */
class QuotedConversion extends Transaction
{

    /**
     * @var string
     */
    var $QuoteId;

    /**
     * @var ConversionRate
     */
    var $ConversionRateResponse;

}