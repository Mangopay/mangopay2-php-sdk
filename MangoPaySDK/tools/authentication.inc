<?php
namespace MangoPay;

class Authentication {
    
    /**
     * Type of authentication
     * @var AuthenticationType
     */
    private $_authenticationType;
    
    /**
     * Construct
     * @throws MangoPay\Exception If constant MangoPay_AuthenticationType is not defined or it has wrong value
     */
    function __construct() {
        
        switch (ApiBase::$Config->AuthenticationType) {
            case "Basic":
                $this->_authenticationType = AuthenticationType::Basic;
                break;
             case "Strong":
                $this->_authenticationType = AuthenticationType::Strong;
                break;
            default:
                // Error - wrong value for MangoPay_AuthenticationType constant
                $errorMsg = 'Wrong value for AuthenticationType. ';
                $errorMsg .= 'Possible values: Basic or Strong';
                throw new Exception ($errorMsg);
        }
    }
    
    /**
     * Get HTTP header value with authorization string
     * 
     * @param MangoPay\OAuth $oauth Token value for OAuth authentication
     * @return string Authorization string
     */
    public function GetHttpHeaderKey($oauth, $restUrl, $requestMethod, $requestData){
        
        switch ($this->_authenticationType) {
            case AuthenticationType::Basic:
                return $this->GetHttpHeaderBasic();
            case AuthenticationType::Strong:
                return $this->GetHttpHeaderStrong($oauth);
        }
    }
    
    /**
     * Get basic key for HTTP header
     * @return string
     * @throws Exception If MangoPay_ClientId or MangoPay_ClientPassword is not defined
     */
    public static function GetHttpHeaderBasicKey() {
        if (is_null(ApiBase::$Config->ClientId) || strlen(ApiBase::$Config->ClientId) == 0)
            throw new Exception ('Neither MangoPay_ClientId constant nor ClientId setting is defined.');
        
        if (is_null(ApiBase::$Config->ClientPassword) || strlen(ApiBase::$Config->ClientPassword) == 0)
            throw new Exception ('Neither MangoPay_ClientPassword constant nor ClientPassword setting is defined.');
        
        $signature = ApiBase::$Config->ClientId . ':' . ApiBase::$Config->ClientPassword;
        return base64_encode($signature);
    }
    
    /**
     * Get HTTP header value with authorization string for basic authentication
     * 
     * @return string Value for HTTP header with authentication string
     * @throws MangoPay\Exception If required constants are not defined.
     */
    private function GetHttpHeaderBasic() {
        
        return 'Authorization: Basic ' . self::GetHttpHeaderBasicKey();
    }
    
    /**
     * Get HTTP header value with authorization string for strong authentication
     * 
     * @return string Value for HTTP header with authentication string
     * @throws MangoPay\Exception If required constants are not defined.
     */
    private function GetHttpHeaderStrong($oauth){
        
        if (is_null($oauth) || !isset($oauth->access_token) || !isset($oauth->token_type))
            throw new Exception ('Tokens or Token type is not defined for strong authentication');
                
        return 'Authorization: ' . $oauth->token_type . ' ' . $oauth->access_token;
    }
}