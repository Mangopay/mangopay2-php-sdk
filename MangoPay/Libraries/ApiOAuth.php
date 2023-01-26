<?php

namespace MangoPay\Libraries;

/**
 * Authentication manager
 */
class ApiOAuth extends ApiBase
{
    /**
     * Get token information to OAuth Authentication
     * @return \MangoPay\Libraries\OAuthToken OAuthToken object with token information
     */
    public function CreateToken()
    {
        $urlMethod = $this->GetRequestUrl('authentication_oauth');
        $requestType = $this->GetRequestType('authentication_oauth');
        $requestData = [
            'grant_type' => 'client_credentials'
        ];

        $rest = new RestTool($this->_root, false, false);
        $authHlp = new AuthenticationHelper($this->_root);

        $urlDetails = parse_url($this->_root->Config->BaseUrl);
        $rest->AddRequestHttpHeader('Host: ' . @$urlDetails['host']);
        $rest->AddRequestHttpHeader('Authorization: Basic ' . $authHlp->GetHttpHeaderBasicKey());
        $rest->AddRequestHttpHeader('Content-Type: application/x-www-form-urlencoded');
        $response = $rest->Request($urlMethod, $requestType, $requestData);
        $token = $this->CastResponseToEntity($response, '\MangoPay\Libraries\OAuthToken');
        $token->autentication_key = $authHlp->GetAutenticationKey();

        return $token;
    }
}
