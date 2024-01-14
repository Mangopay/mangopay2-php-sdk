<?php

namespace MangoPay;

class BankingAliasOTHER extends BankingAlias
{
    /**
     * @var Type
     */
    public $Type;

    /**
     * Account Number
     */
    public $AccountNumber;

    /**
     * BIC
     */
    public $BIC;

    /**
     * Country
     * @see \MangoPay\CountryIso
     */
    public $Country;
}
