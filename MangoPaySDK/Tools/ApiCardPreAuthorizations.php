<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for pre-authorization process
 */
class ApiCardPreAuthorizations extends ApiBase {

    /**
     * Create new pre-authorization object
     * @param \MangoPay\Entities\CardPreAuthorization $cardPreAuthorization PreAuthorization object to create
     * @return \MangoPay\Entities\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Create($cardPreAuthorization) {
        return $this->CreateObject('preauthorization_create', $cardPreAuthorization, '\MangoPay\Entities\CardPreAuthorization');
    }

    /**
     * Get pre-authorization object
     * @param int $cardPreAuthorizationId PreAuthorization identifier
     * @return \MangoPay\Entities\CardPreAuthorization Card registration  object returned from API
     */
    public function Get($cardPreAuthorizationId) {
        return $this->GetObject('preauthorization_get', $cardPreAuthorizationId, '\MangoPay\Entities\CardPreAuthorization');
    }

    /**
     * Update pre-authorization object
     * @param \MangoPay\Entities\CardPreAuthorization $preAuthorization PreAuthorization object to save
     * @return \MangoPay\Entities\CardPreAuthorization PreAuthorization object returned from API
     */
    public function Update($cardPreAuthorization) {
        return $this->SaveObject('preauthorization_save', $cardPreAuthorization, '\MangoPay\Entities\CardPreAuthorization');
    }
}
