<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for responses
 * See 
 */

 /**
 * Class ApiResponses
 * @package MangoPay
 */
class ApiResponses extends Libraries\ApiBase
{
    /**
     * Get response from previous call by idempotency key
     * @param string $idempotencyKey Idempotency key
     * @return \MangoPay\Response Entity of Response object
     */
    public function Get($idempotencyKey)
    {
        $response = $this->GetObject('responses_get', $idempotencyKey, 'MangoPay\Response');
        $className = $this->GetObjectForIdempotencyUrl($response->RequestURL);
        if (is_null($className) || empty($className) || is_null($response->Resource) || empty($response->Resource))
            return $response;
        
        $response->Resource = $this->CastResponseToEntity($response->Resource, $className);
        return $response;
    }
}
