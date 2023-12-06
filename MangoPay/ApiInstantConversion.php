<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for instant conversions
 */
class ApiInstantConversion extends Libraries\ApiBase
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
     * @return \MangoPay\InstantConversion object returned from API
     */
    public function CreateInstantConversion($instantConversion)
    {
        return $this->CreateObject('create_instant_conversion', $instantConversion, '\MangoPay\InstantConversion');
    }

    /**
     * This endpoint allows the platform to get
     * the details of a conversion which has been carried out.
     * @param string $id The unique identifier of the conversion.
     * @return \MangoPay\InstantConversion object returned from API
     */
    public function GetInstantConversion($id)
    {
        return $this->GetObject('get_instant_conversion', '\MangoPay\InstantConversion', $id);
    }
}
