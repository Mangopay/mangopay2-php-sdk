<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pre-authorization process
 */
class ApiCardPreAuthorizations extends Libraries\ApiBase
{
    /**
     * Create new pre-authorization object
     * @param \MangoPay\CardPreAuthorization $cardPreAuthorization PreAuthorization object to create
     * @return \MangoPay\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Create($cardPreAuthorization, $idempotencyKey = null)
    {
        return $this->CreateObject('preauthorization_create', $cardPreAuthorization, '\MangoPay\CardPreAuthorization', null, null, $idempotencyKey);
    }
    
    /**
     * Get pre-authorization object
     * @param int $cardPreAuthorizationId PreAuthorization identifier
     * @return \MangoPay\CardPreAuthorization Card registration  object returned from API
     */
    public function Get($cardPreAuthorizationId)
    {
        return $this->GetObject('preauthorization_get', $cardPreAuthorizationId, '\MangoPay\CardPreAuthorization');
    }
    
    /**
     * Update pre-authorization object
     * @param \MangoPay\CardPreAuthorization $cardPreAuthorization PreAuthorization object to save
     * @return \MangoPay\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Update($cardPreAuthorization)
    {
        return $this->SaveObject('preauthorization_save', $cardPreAuthorization, '\MangoPay\CardPreAuthorization');
    }
}
