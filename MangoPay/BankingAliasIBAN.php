<?php

namespace MangoPay;

/**
 * Bank Account entity
 */
class BankingAliasIBAN extends BankingAlias
{
    /**
     * The type of banking alias (note that only IBAN is available at present)
     * @var \MangoPay\BankingAliasType
     */
    public $Type = BankingAliasType::IBAN;

    /**
     * The IBAN of the banking alias
     * @var string
     */
    public $IBAN;

    /**
     * The BIC of the banking alias
     * @var string
     */
    public $BIC;

    /**
     * The country
     * @var string
     */
    public $Country;
}
