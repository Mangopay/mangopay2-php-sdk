<?php

namespace MangoPay;

class LocalAccount extends Libraries\Dto
{
    /**
     * The account number of the account
     * @var string
     */
    public $AccountNumber;

    /**
     * The sort code of the account.
     * @var string
     */
    public $SortCode;
}
