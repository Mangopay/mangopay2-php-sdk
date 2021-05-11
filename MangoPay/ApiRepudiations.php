<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API for Repudiations
 */
class ApiRepudiations extends Libraries\ApiBase
{
    /**
     * @param string $repudiationId
     */
    public function Get($repudiationId)
    {
        return $this->GetObject('repudiation_get', '\MangoPay\Repudiation', $repudiationId);
    }

    /**
     * Retrieves a list of Refunds pertaining to a certain Repudiation
     * @param string $repudiationId Repudiation identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterRefunds $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\Refund[]
     */
    public function GetRefunds($repudiationId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_repudiation', $pagination, '\MangoPay\Repudiation', $repudiationId, $filter, $sorting);
    }
}
