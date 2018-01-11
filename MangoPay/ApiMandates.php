<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for mandates
 */
class ApiMandates extends Libraries\ApiBase
{
    /**
     * Create new mandate
     * @param Mandate $mandate
     * @return \MangoPay\Mandate Mandate object returned from API
     */
    public function Create($mandate, $idempotencyKey = null)
    {
        return $this->CreateObject('mandates_create', $mandate, '\MangoPay\Mandate', null, null, $idempotencyKey);
    }
    
    /**
     * Get mandate
     * @param string $mandateId Mandate identifier
     * @return \MangoPay\Mandate Mandate object returned from API
     */
    public function Get($mandateId)
    {
        return $this->GetObject('mandates_get', $mandateId, '\MangoPay\Mandate');
    }
    
    /**
     * Cancel mandate
     * @param string $mandateId Id of mandate object to cancel
     * @return \MangoPay\Mandate Mandate object returned from API
     */
    public function Cancel($mandateId)
    {
        $mandate = new \MangoPay\Mandate();
        $mandate->Id = $mandateId;
        
        return $this->SaveObject('mandates_save', $mandate, '\MangoPay\Mandate');
    }
    
    /**
     * Get all mandates
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return array Array with mandates
     */
    public function GetAll(& $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('mandates_all', $pagination, 'MangoPay\Mandate', null, $filter, $sorting);
    }

    /**
     * Retrieves list of Transactions pertaining to a certain Mandate
     * @param string $mandateId Mandate identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     */
    public function GetTransactions($mandateId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('transactions_get_for_mandate', $pagination, '\MangoPay\Transaction', $mandateId, $filter, $sorting);
    }
}
