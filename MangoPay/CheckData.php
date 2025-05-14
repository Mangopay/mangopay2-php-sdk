<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class CheckData extends Dto
{
    /**
     * The type of the data point.
     * @var string
     */
    public $Type;

    /**
     * The value of the data point.
     * @var string
     */
    public $Value;
}
