<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class RecurringPayInCurrentState extends Dto
{
    /**
     * @var integer
     */
    public $PayinsLinked;

    /**
     * @var Money
     */
    public $CumulatedDebitedAmount;

    /**
     * @var Money
     */
    public $CumulatedFeesAmount;

    /**
     * @var string
     */
    public $LastPayinId;
}
