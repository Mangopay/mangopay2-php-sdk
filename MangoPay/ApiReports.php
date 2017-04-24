<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for reports
 */
class ApiReports extends Libraries\ApiBase
{
    /**
     * Creates new report request
     * @param \MangoPay\ReportRequest $reportRequest
     * @return \MangoPay\ReportRequest Report request instance returned from API
     */
    public function Create($reportRequest, $idempotencyKey = null)
    {
        $type = $reportRequest->ReportType;
        if (is_null($type) || strlen($type) == 0)
            throw new Libraries\Exception('Report type property is reguire when create a report request.');
        
        return $this->CreateObject('reports_create', $reportRequest, '\MangoPay\ReportRequest', $type, null, $idempotencyKey);
    }
    
    /**
     * Gets report request.
     * @param int $reportRequestId Report request identifier
     * @return \MangoPay\ReportRequest Report request instance returned from API
     */
    public function Get($reportRequestId)
    {
        return $this->GetObject('reports_get', $reportRequestId, '\MangoPay\ReportRequest');
    }
    
    /**
     * Gets all report requests.
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return array Array with report requests
     */
    public function GetAll(& $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('reports_all', $pagination, 'MangoPay\ReportRequest', null, $filter, $sorting);
    }
}
