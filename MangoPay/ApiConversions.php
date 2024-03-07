<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for instant conversions
 */
class ApiConversions extends Libraries\ApiBase
{
    /**
     * This endpoint allows the platform to get a real
     * time indicative market rate of a specific currency pair.
     * The rate returned is given in real time.
     * @param string $debitedCurrency The sell currency – the currency of the wallet to be debited
     * @param string $creditedCurrency The buy currency – the currency of the wallet to be credited.
     * @return \MangoPay\ConversionRate object returned from API
     */
    public function GetConversionRate($debitedCurrency, $creditedCurrency)
    {
        return $this->GetObject('get_conversion_rate', '\MangoPay\ConversionRate', $debitedCurrency, $creditedCurrency);
    }

    /**
     * This endpoint allows the platform to move funds between two
     * wallets of different currencies instantaneously.
     * @param CreateInstantConversion $instantConversion
     * @return \MangoPay\Conversion object returned from API
     */
    public function CreateInstantConversion($instantConversion)
    {
        return $this->CreateObject('create_instant_conversion', $instantConversion, '\MangoPay\Conversion');
    }

    /**
     * This call triggers a conversion, at the rate guaranteed by its quote, of the debited funds to the credited wallet.
     *
     * @param CreateQuotedConversion $quotedConversion
     * @return Conversion
     */
    public function CreateQuotedConversion($quotedConversion)
    {
        return $this->CreateObject('create_quoted_conversion', $quotedConversion, '\MangoPay\Conversion');
    }

    /**
     * This endpoint allows the platform to get
     * the details of a conversion which has been carried out.
     * @param string $id The unique identifier of the conversion.
     * @return \MangoPay\Conversion object returned from API
     */
    public function GetConversion($id)
    {
        return $this->GetObject('get_conversion', '\MangoPay\Conversion', $id);
    }

    /**
     * This call guarantees a conversion rate to let you Create a Quoted Conversion.
     * @param ConversionQuote $quote
     * @return ConversionQuote
     */
    public function CreateConversionQuote($quote)
    {
        return $this->CreateObject('create_conversion_quote', $quote, '\MangoPay\ConversionQuote');
    }

    /**
     * This endpoint allows the platform to get the details of a quote
     * @param string $quoteId
     * @return ConversionQuote
     */
    public function GetConversionQuote($quoteId)
    {
        return $this->GetObject('get_conversion_quote', '\MangoPay\ConversionQuote', $quoteId);
    }
}
