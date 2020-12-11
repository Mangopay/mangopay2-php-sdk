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
     * @var string
     */
    public $ColorDepth;

    /**
     * @var string
     */
    public $ScreenHeight;

    /**
     * @var string
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
     * @var string
     */
    public $JavascriptEnabled;
}