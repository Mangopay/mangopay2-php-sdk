<?php

namespace MangoPay\Tests\Cases;


/**
 * Tests basic methods for report requests
 */
class ReportsTest extends Base
{

    function test_ReportRequestTransactions_Create()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;

        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $this->assertNotNull($createReportRequest);
        $this->assertTrue($createReportRequest->Id > 0);
        $this->assertSame($createReportRequest->ReportType, \MangoPay\ReportType::Transactions);
    }

    function test_ReportRequestWallets_Create()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Wallets;

        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $this->assertNotNull($createReportRequest);
        $this->assertTrue($createReportRequest->Id > 0);
        $this->assertSame($createReportRequest->ReportType, \MangoPay\ReportType::Wallets);
    }

    function test_ReportRequest_Get()
    {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        $createReportRequest = $this->_api->Reports->Create($reportRequest);

        $getReportRequest = $this->_api->Reports->Get($createReportRequest->Id);

        $this->assertNotNull($getReportRequest);
        $this->assertSame($getReportRequest->Id, $createReportRequest->Id);
        $this->assertSame($getReportRequest->ReportType, $createReportRequest->ReportType);
    }

    function test_ReportRequest_All()
    {
        $pagination = new \MangoPay\Pagination(1, 1);

        $getAllReportRequests = $this->_api->Reports->GetAll($pagination);

        $this->assertEquals(1, count($getAllReportRequests));
        $this->assertInstanceOf('\MangoPay\ReportRequest', $getAllReportRequests[0]);
    }

    function test_ReportRequest_All_SortByCreationDate()
    {
        $pagination = new \MangoPay\Pagination(1, 1);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $getAllReportRequests = $this->_api->Reports->GetAll($pagination, null, $sorting);

        $this->assertEquals(1, count($getAllReportRequests));
        $this->assertInstanceOf('\MangoPay\ReportRequest', $getAllReportRequests[0]);
    }
}
