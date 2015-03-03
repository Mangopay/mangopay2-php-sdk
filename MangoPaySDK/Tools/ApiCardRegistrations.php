<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for card registrations
 */
class ApiCardRegistrations extends ApiBase {

    /**
     * Create new card registration
     * @param \MangoPay\Entities\CardRegistration $cardRegistration Card registration object to create
     * @return \MangoPay\Entities\CardRegistration Card registration object returned from API
     */
    public function Create($cardRegistration) {
        return $this->CreateObject('cardregistration_create', $cardRegistration, '\MangoPay\Entities\CardRegistration');
    }

    /**
     * Get card registration
     * @param int $cardRegistrationId Card Registration identifier
     * @return \MangoPay\Entities\CardRegistration Card registration  object returned from API
     */
    public function Get($cardRegistrationId) {
        return $this->GetObject('cardregistration_get', $cardRegistrationId, '\MangoPay\Entities\CardRegistration');
    }

    /**
     * Update card registration
     * @param \MangoPay\Entities\CardRegistration $cardRegistration Card registration object to save
     * @return \MangoPay\Entities\CardRegistration Card registration object returned from API
     */
    public function Update($cardRegistration) {
        return $this->SaveObject('cardregistration_save', $cardRegistration, '\MangoPay\Entities\CardRegistration');
    }
}
