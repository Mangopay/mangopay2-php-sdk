<?php

namespace MangoPay;

class VirtualAccountCapabilities
{
    /**
     * Whether local bank wires can be made to this account.
     * @var Boolean
     */
    public $LocalPayInAvailable;

    /**
     * Whether international bank wires can be made to this account
     * @var Boolean
     */
    public $InternationalPayInAvailable;

    /**
     * List of currencies supported by the account
     * @var CurrencyIso[]
     */
    public $Currencies;
}