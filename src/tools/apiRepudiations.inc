<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for repudiations
 */
class ApiRepudiations extends ApiBase {
    
    /**
     * Get repudiation object
     * @param $repudiationId Repudiation identifier
     * @return \MangoPay\Repudiation Object returned from API
     */
    public function Get($repudiationId) {
        return $this->GetObject('repudiations_get', $repudiationId, '\MangoPay\Repudiation');
    }
}