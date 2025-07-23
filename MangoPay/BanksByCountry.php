<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class BanksByCountry extends Dto
{
    /**
     * @var array<Bank>
     */
    public $Banks;

    /**
     * @var string
     */
    public $Country;
}