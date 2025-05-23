<?php

namespace MangoPay;

class InternationalAccountDetails extends Libraries\Dto
{
    /**
     * Information about the address associated with the international IBAN account.
     * @var VirtualAccountAddress
     */
    public $Address;

    /**
     * The IBAN and BIC of the account.
     * @var InternationalAccount
     */
    public $Account;

    /**
     * @var string
     */
    public $BankName;
}
