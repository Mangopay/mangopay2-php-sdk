<?php

namespace MangoPay;

/**
 * Class to management of Mangopay’s Reporting Service (2025)
 */
class ApiReportsV2 extends Libraries\ApiBase
{
    /**
     * Generate a reporting service report
     * @param Report $report
     * @return Report Report instance returned from API
     */
    public function Create($report, $idempotencyKey = null)
    {
        return $this->CreateObject(
            'reports_create',
            $report,
            '\MangoPay\Report',
            null,
            null,
            $idempotencyKey
        );
    }

    /**
     * Gets a Report.
     * @param string $reportId Report identifier
     * @return Report Report instance returned from API
     */
    public function Get($reportId)
    {
        return $this->GetObject('reports_get_v2', '\MangoPay\Report', $reportId);
    }

    /**
     * Gets all Reports.
     * @param FilterReportsV2 $filter Object to filter data
     * @param Pagination $pagination Pagination object
     * @param Sorting $sorting Object to sorting data
     * @return Report[] Array with Reports
     */
    public function GetAll($filter = null, $pagination = null, $sorting = null)
    {
        return $this->GetList(
            'reports_all_v2',
            $pagination,
            'MangoPay\Report',
            null,
            $filter,
            $sorting
        );
    }
}
