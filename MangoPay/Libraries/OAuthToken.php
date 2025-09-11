<?php

namespace MangoPay\Libraries;

/**
 * OAuthToken
 */
class OAuthToken extends Dto
{
    /**
     * Created time
     * @var int
     */
    public $create_time;

    /**
     * Value of token
     * @var string
     */
    public $access_token;

    /**
     * Token type
     * @var string
     */
    public $token_type;

    /**
     * Expires time for the token
     * @var int
     */
    public $expires_in;

    /**
     * Autentication key
     * @var string
     */
    public $autentication_key;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->create_time = time() - 30;
    }

    /**
     * Check that current tokens are expire and return true if yes
     * @return bool
     */
    public function IsExpired()
    {
        return (time() >= ($this->create_time + $this->expires_in));
    }

    public function GetAutenticationKey()
    {
        return $this->autentication_key;
    }
}
