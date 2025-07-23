<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class Bank extends Dto
{
    /**
     * @var string
     */
    public $BankName;

    /**
     * @var array<string>
     */
    public $Scheme;

    /**
     * @var string
     */
    public $Name;
}