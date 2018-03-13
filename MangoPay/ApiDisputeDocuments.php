<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for dispute documents
 */
/**
 * Class ApiDisputeDocuments
 * @package MangoPay
 */
class ApiDisputeDocuments extends Libraries\ApiBase
{
    /**
     * Gets dispute's document
     * @param int|GUID $documentId Dispute's document identifier
     * @return \MangoPay\DisputeDocument Dispute's document object returned from API
     */
    public function Get($documentId)
    {
        return $this->GetObject('disputes_document_get', $documentId, 'MangoPay\DisputeDocument');
    }

    /**
     * Gets dispute's documents for client
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterKycDocuments $filter Filtering object
     * @return array List of dispute documents returned from API
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_document_all', $pagination, 'MangoPay\DisputeDocument', null, $filter, $sorting);
    }

    /**
     * Creates temporary URLs where each page of a dispute document can be viewed.
     *
     * @param string $documentId Identification of the document whose pages to view
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array of consults for viewing the dispute document's pages
     */
    public function CreateDisputeDocumentConsult($documentId, & $pagination = null)
    {
        return $this->GetList('disputes_document_create_consult', $pagination, 'MangoPay\DocumentPageConsult', $documentId, null, null);
    }
}
