<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for KYC document list
 */
class ApiKycDocuments extends Libraries\ApiBase
{
    /**
     * Get all KYC documents
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterKycDocuments $filter Object to filter data
     * @return \MangoPay\KycDocument[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('kyc_documents_all', $pagination, '\MangoPay\KycDocument', null, $filter, $sorting);
    }
    
     /**
     * Get KYC document
     * @param string $kycDocumentId Document identifier
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function Get($kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get_alt', $kycDocumentId, '\MangoPay\KycDocument');
    }


    /**
     * Creates temporary URLs where each page of a KYC document can be viewed.
     *
     * @param string $kycDocumentId Identification of the document whose pages to view
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array of consults for viewing the KYC document's pages
     * @throws Libraries\Exception
     */
    public function CreateKycDocumentConsult($kycDocumentId, & $pagination = null)
    {
        return $this->GetList('kyc_documents_create_consult', $pagination, '\MangoPay\DocumentPageConsult', $kycDocumentId, null, null);
    }
}
