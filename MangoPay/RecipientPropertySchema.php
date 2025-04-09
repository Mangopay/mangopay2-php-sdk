<?php

namespace MangoPay;

class RecipientPropertySchema extends Libraries\Dto
{
    /**
     * @var bool
     */
    public $Required;

    /**
     * @var int
     */
    public $MaxLength;

    /**
     * @var int
     */
    public $MinLength;

    /**
     * @var string
     */
    public $Pattern;

    /**
     * @var array
     */
    public $AllowedValues;

    /**
     * @var string
     */
    public $Label;

    /**
     * @var string
     */
    public $EndUserDisplay;
}
