<?php

namespace MangoPay;

class VirtualAccountCapabilities extends Libraries\Dto
{
    /**
     * Whether local bank wires can be made to this account.
     * @var bool
     */
    public $LocalPayInAvailable;

    /**
     * Whether international bank wires can be made to this account
     * @var bool
     */
    public $InternationalPayInAvailable;

    /**
     * List of currencies supported by the account
     * @var CurrencyIso[]
     */
    public $Currencies;
}
