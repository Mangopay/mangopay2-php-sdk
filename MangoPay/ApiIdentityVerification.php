<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for Identity Verification Sessions
 */
class ApiIdentityVerification extends Libraries\ApiBase
{
    /**
     * Create new IdentityVerification
     * @param IdentityVerification $identityVerification
     * @return \MangoPay\IdentityVerification IdentityVerification object returned from API
     */
    public function Create($identityVerification, $userId, $idempotencyKey = null)
    {
        return $this->CreateObject('identify_verification_create', $identityVerification, '\MangoPay\IdentityVerification', $userId, null, $idempotencyKey);
    }

    /**
     * Get IdentityVerification
     * @param string $id IdentityVerification identifier
     * @return \MangoPay\IdentityVerification IdentityVerification object returned from API
     */
    public function Get($id)
    {
        return $this->GetObject('identify_verification_get', '\MangoPay\IdentityVerification', $id);
    }

    /**
     * Get IdentityVerificationCheck
     * @param string $id IdentityVerification identifier
     * @return \MangoPay\IdentityVerificationCheck IdentityVerificationCheck object returned from API
     */
    public function GetChecks($id)
    {
        return $this->GetObject('identify_verification_checks_get', '\MangoPay\IdentityVerificationCheck', $id);
    }
}
