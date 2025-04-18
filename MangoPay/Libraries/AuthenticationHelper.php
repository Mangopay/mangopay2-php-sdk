<?php

namespace MangoPay\Libraries;

class AuthenticationHelper
{
    /**
     * Root/parent instance that holds the OAuth token and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    private $_root;

    /**
     * Constructor
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @param \MangoPay\MangoPayApi $root
     */
    public function __construct($root)
    {
        $this->_root = $root;
    }

    /**
     * Get HTTP header value with authorization string
     * @return string Authorization string
     */
    public function GetHttpHeaderKey()
    {
        return $this->GetHttpHeaderStrong();
    }

    /**
     * Get basic key for HTTP header
     * @return string
     * @throws \MangoPay\Libraries\Exception If MangoPay_ClientId or MangoPay_ClientPassword is not defined
     */
    public function GetHttpHeaderBasicKey()
    {
        if (is_null($this->_root->Config->ClientId) || strlen($this->_root->Config->ClientId) == 0) {
            throw new Exception('MangoPayApi.Config.ClientId is not set.');
        }

        if (is_null($this->_root->Config->ClientPassword) || strlen($this->_root->Config->ClientPassword) == 0) {
            throw new Exception('MangoPayApi.Config.ClientPassword is not set.');
        }

        $signature = $this->_root->Config->ClientId . ':' . $this->_root->Config->ClientPassword;
        return base64_encode($signature);
    }

    public function GetAutenticationKey()
    {
        if (is_null($this->_root->Config->ClientId) || strlen($this->_root->Config->ClientId) == 0) {
            throw new Exception('MangoPayApi.Config.ClientId is not set.');
        }

        if (is_null($this->_root->Config->BaseUrl) || strlen($this->_root->Config->BaseUrl) == 0) {
            throw new Exception('MangoPayApi.Config.BaseUrl is not set.');
        }

        return md5($this->_root->Config->BaseUrl.
                    $this->_root->Config->ClientId.
                    $this->_root->Config->ClientPassword);
    }

    /**
     * Get HTTP header value with authorization string for basic authentication
     *
     * @return string Value for HTTP header with authentication string
     * @throws \MangoPay\Libraries\Exception If required constants are not defined.
     */
    private function GetHttpHeaderBasic()
    {
        return 'Authorization: Basic ' . $this->GetHttpHeaderBasicKey();
    }

    /**
     * Get HTTP header value with authorization string for strong authentication
     *
     * @return string Value for HTTP header with authentication string
     * @throws \MangoPay\Libraries\Exception If OAuth token is not created (or is invalid) for strong authentication.
     */
    private function GetHttpHeaderStrong()
    {
        $token = $this->_root->OAuthTokenManager->GetToken($this->GetAutenticationKey());

        if (is_null($token) || !isset($token->access_token) || !isset($token->token_type)) {
            throw new Exception('OAuth token is not created (or is invalid) for strong authentication');
        }

        return 'Authorization: ' . $token->token_type . ' ' . $token->access_token;
    }
}
