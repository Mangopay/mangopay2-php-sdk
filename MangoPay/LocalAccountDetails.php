<?php

namespace MangoPay;

class LocalAccountDetails extends Libraries\Dto
{
    /**
     * Information about the address associated with the local IBAN account.
     * @var VirtualAccountAddress
     */
    public $Address;

    /**
     * Information about the address associated with the local IBAN account.
     * @var LocalAccount
     */
    public $Account;

    /**
     * @var string
     */
    public $BankName;
}
