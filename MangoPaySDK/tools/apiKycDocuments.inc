<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for KYC document list
 */
class ApiKycDocuments extends ApiBase {
    
    /**
     * Get all KYC documents
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return \MangoPay\KycDocument[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null) {
        return $this->GetList('kyc_documents_all', $pagination, '\MangoPay\KycDocument');
    }
}