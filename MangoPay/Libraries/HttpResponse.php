<?php
namespace MangoPay\Libraries;

/**
 * Base class for Http Client
 */
class HttpResponse
{
    /**
     * @var int
     */
    public $ResponseCode;

    /**
     * @var array
     */
    public $Headers;

    /**
     * @var string
     */
    public $Body;
}
