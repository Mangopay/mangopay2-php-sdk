<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiOAuth extends ApiBase {
    
    /**
     * Get token information to OAuth Authentication
     * @return \MangoPay\OAuth OAuth object with token information
     */
    public function Token() {
        
        $urlMethod = $this->GetRequestUrl('authentication_oauth');
        $requestType = $this->GetRequestType('authentication_oauth');
        $requestData = array(
            'grant_type' => 'client_credentials'
        );
        
        $rest = $this->GetRestToolObject(false);
        
        $urlDetails = parse_url(MangoPay_BaseUrl);
        $rest->AddRequestHttpHeader('Host: ' . $urlDetails['host']);
        $rest->AddRequestHttpHeader('Authorization: Basic ' . Authentication::GetHttpHeaderBasicKey());
        $rest->AddRequestHttpHeader('Content-Type: application/x-www-form-urlencoded');
        $response = $rest->Request($urlMethod, $requestType, $requestData);
        return $this->CastResponseToEntity($response, '\MangoPay\OAuth');
    }
}