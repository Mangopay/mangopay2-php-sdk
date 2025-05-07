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
        return $this->CreateObject('identity_verification_create', $identityVerification, '\MangoPay\IdentityVerification', $userId, null, $idempotencyKey);
    }

    /**
     * Get IdentityVerification
     * @param string $id IdentityVerification identifier
     * @return \MangoPay\IdentityVerification IdentityVerification object returned from API
     */
    public function Get($id)
    {
        return $this->GetObject('identity_verification_get', '\MangoPay\IdentityVerification', $id);
    }

    /**
     * Get all IdentityVerifications for a user
     * @param string $userId User identifier
     * @return \MangoPay\IdentityVerification[] IdentityVerification list returned from API
     */
    public function GetAll($userId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('identity_verification_get_all', $pagination, '\MangoPay\IdentityVerification', $userId, $filter, $sorting);
    }
}
