<?php
namespace MangoPay;

/**
 * Class to manage MangoPay API for Repudiations
 */
class ApiRepudiations extends Libraries\ApiBase
{

    /**
     * Retrieves a list of Refunds pertaining to a certain Repudiation
     * @param string $repudiationId Repudiation identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterRefunds $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     */
    public function GetRefunds($repudiationId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_repudiation', $pagination, '\MangoPay\Refund', $repudiationId, $filter, $sorting);
    }
}