<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for card registration
 */
class ApiCardRegistration extends ApiBase {
    
    /**
     * Create payment card registration
     * @param \MangoPay\PaymentCardRegistration $cardRegistration PaymentCardRegistration object to create
     * @return \MangoPay\PaymentCardRegistration Payment card registration object returned from API
     */
    public function Create($cardRegistration) {
        return $this->CreateObject('paymentcardregistration_create', $cardRegistration, '\MangoPay\PaymentCardRegistration');
    }
    
    /**
     * Get payment card registration
     * @param int $cardRegistrationId Payment card registration identifier
     * @return \MangoPay\PaymentCardRegistration Card registration object returned from API
     */
    public function Get($cardRegistrationId) {
        return $this->GetObject('paymentcardregistration_get', $cardRegistrationId, '\MangoPay\PaymentCardRegistration');
    }
}