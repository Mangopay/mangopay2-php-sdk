<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiClients extends ApiBase {
   
    /**
     * Get client data for Basic Access Authentication 
     * @param string $clientId Client identifier
     * @param string $clientName Beautiful name for presentation
     * @return Clinet Client object
     */
    public function Create($clientId, $clientName) {

        $urlMethod = $this->GetRequestUrl('authentication_base');
        $requestType = $this->GetRequestType('authentication_base');
        $requestData = array(
            'ClientID' => $clientId,
            'Name' => $clientName
        );
        
        $rest = $this->GetRestToolObject(false);
        $response = $rest->Request($urlMethod, $requestType, $requestData);
        return $this->CastResponseToEntity($response, 'MangoPay\Client');
    }
}