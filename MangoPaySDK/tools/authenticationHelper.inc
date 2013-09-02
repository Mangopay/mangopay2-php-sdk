<?php
namespace MangoPay;

class AuthenticationHelper {
    
    /**
     * Root/parent instance that holds the OAuth token and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    private $_root;

    /**
     * Constructor
     * @param \MangoPay\MangoPayApi Root/parent instance that holds the OAuth token and Configuration instance
     */
    function __construct($root) {
        $this->_root = $root;
    }
    
    /**
     * Get HTTP header value with authorization string
     * @return string Authorization string
     */
    public function GetHttpHeaderKey(){
        return $this->GetHttpHeaderStrong();
//        switch ($this->_root->Config->AuthenticationType) {
//            case AuthenticationType::Basic:
//                return $this->GetHttpHeaderBasic();
//            case AuthenticationType::Strong:
//                return $this->GetHttpHeaderStrong();
//        }
    }
    
    /**
     * Get basic key for HTTP header
     * @return string
     * @throws \MangoPay\Exception If MangoPay_ClientId or MangoPay_ClientPassword is not defined
     */
    public function GetHttpHeaderBasicKey() {
        if (is_null($this->_root->Config->ClientId) || strlen($this->_root->Config->ClientId) == 0)
            throw new Exception ('Neither MangoPay_ClientId constant nor ClientId config setting is defined.');
        
        if (is_null($this->_root->Config->ClientPassword) || strlen($this->_root->Config->ClientPassword) == 0)
            throw new Exception ('Neither MangoPay_ClientPassword constant nor ClientPassword config setting is defined.');
        
        $signature = $this->_root->Config->ClientId . ':' . $this->_root->Config->ClientPassword;
        return base64_encode($signature);
    }
    
    /**
     * Get HTTP header value with authorization string for basic authentication
     * 
     * @return string Value for HTTP header with authentication string
     * @throws \MangoPay\Exception If required constants are not defined.
     */
    private function GetHttpHeaderBasic() {
        
        return 'Authorization: Basic ' . $this->GetHttpHeaderBasicKey();
    }
    
    /**
     * Get HTTP header value with authorization string for strong authentication
     * 
     * @return string Value for HTTP header with authentication string
     * @throws \MangoPay\Exception If required constants are not defined.
     */
    private function GetHttpHeaderStrong(){
        $oauth = $this->_root->OAuthToken;

        if (is_null($oauth) || !isset($oauth->access_token) || !isset($oauth->token_type))
            throw new Exception ('OAuth token is not created (or is invalid) for strong authentication');

        return 'Authorization: ' . $oauth->token_type . ' ' . $oauth->access_token;
    }
}