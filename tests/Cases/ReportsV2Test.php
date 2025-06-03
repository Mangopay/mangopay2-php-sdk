<?php

namespace Cases;

use MangoPay\FilterReportsV2;
use MangoPay\Report;
use MangoPay\Tests\Cases\Base;

/**
 * Tests basic methods for report requests
 */
class ReportsV2Test extends Base
{
    public function test_Reports_Create_CollectedFees()
    {
        $report = $this->getNewReportInstance();
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertNotNull($created->Id);
        $this->assertSame($created->ReportType, "COLLECTED_FEES");
        $this->assertSame($created->Status, "PENDING");
    }

    public function test_Reports_Create_UserWalletTransactions()
    {
        $report = new Report();
        $report->ReportType = "USER_WALLET_TRANSACTIONS";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        $created = $this->_api->ReportsV2->Create($report);

        $this->assertNotNull($created);
        $this->assertNotNull($created->Id);
        $this->assertSame($created->ReportType, "USER_WALLET_TRANSACTIONS");
        $this->assertSame($created->Status, "PENDING");
    }

    public function test_Reports_Get()
    {
        $report = $this->getNewReportInstance();
        $created = $this->_api->ReportsV2->Create($report);
        $fetched = $this->_api->ReportsV2->Get($created->Id);

        $this->assertNotNull($fetched);
        $this->assertNotNull($fetched->Id);
        $this->assertSame($created->Id, $fetched->Id);
    }

    public function test_Reports_GetAll()
    {
        $report = $this->getNewReportInstance();
        $this->_api->ReportsV2->Create($report);
        $fetched = $this->_api->ReportsV2->GetAll();

        $this->assertNotNull($fetched);
        $this->assertTrue(sizeof($fetched) > 0);
    }

    public function test_Reports_GetAll_Filtered()
    {
        $report = $this->getNewReportInstance();
        $this->_api->ReportsV2->Create($report);
        $allResults = $this->_api->ReportsV2->GetAll();

        $filter = new FilterReportsV2();
        $filter->Status = "PENDING";
        $filteredResults = $this->_api->ReportsV2->GetAll($filter);

        $this->assertNotNull($filteredResults);
        $this->assertTrue(sizeof($allResults) > sizeof($filteredResults));
    }

    public function getNewReportInstance()
    {
        $report = new Report();
        $report->ReportType = "COLLECTED_FEES";
        $report->DownloadFormat = "CSV";
        $report->AfterDate = 1740787200;
        $report->BeforeDate = 1743544740;
        return $report;
    }
}
