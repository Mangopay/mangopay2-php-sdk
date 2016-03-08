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
     * @param object $idempotencyKey Idempotency key
     * @return \MangoPay\Response Entity of Response object
     */
    public function Get($idempotencyKey)
    {
        return $this->GetObject('responses_get', $idempotencyKey, 'MangoPay\Response');
    }
}
