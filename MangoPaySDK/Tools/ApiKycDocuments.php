<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for KYC document list
 */
class ApiKycDocuments extends ApiBase {

    /**
     * Get all KYC documents
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return \MangoPay\Entities\KycDocument[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null) {
        return $this->GetList('kyc_documents_all', $pagination, '\MangoPay\Entities\KycDocument', null, null, $sorting);
    }
}
