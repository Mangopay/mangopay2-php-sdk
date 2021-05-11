<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class BrowserInfo extends Dto
{
    /**
     * @var string
     */
    public $AcceptHeader;

    /**
     * @var boolean
     */
    public $JavaEnabled;

    /**
     * @var string
     */
    public $Language;

    /**
     * @var int
     */
    public $ColorDepth;

    /**
     * @var int
     */
    public $ScreenHeight;

    /**
     * @var int
     */
    public $ScreenWidth;

    /**
     * @var string
     */
    public $TimeZoneOffset;

    /**
     * @var string
     */
    public $UserAgent;

    /**
     * @var boolean
     */
    public $JavascriptEnabled;
}
