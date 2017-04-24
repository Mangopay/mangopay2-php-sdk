<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for report requests
 */
class Reports extends Base {
    
    function test_ReportRequest_Create() {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        
        $createReportRequest = $this->_api->Reports->Create($reportRequest);
        
        $this->assertNotNull($createReportRequest);
        $this->assertTrue($createReportRequest->Id > 0);
        $this->assertSame($createReportRequest->ReportType, \MangoPay\ReportType::Transactions);
    }
    
    function test_ReportRequest_Get() {
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        $createReportRequest = $this->_api->Reports->Create($reportRequest);
        
        $getReportRequest = $this->_api->Reports->Get($createReportRequest->Id);
        
        $this->assertNotNull($getReportRequest);
        $this->assertSame($getReportRequest->Id, $createReportRequest->Id);
        $this->assertSame($getReportRequest->ReportType, $createReportRequest->ReportType);
    }
    
    function test_ReportRequest_All() {
        $pagination = new \MangoPay\Pagination(1, 1);
        
        $getAllReportRequests = $this->_api->Reports->GetAll($pagination);

        $this->assertEqual(count($getAllReportRequests), 1);
        $this->assertIsA($getAllReportRequests[0], '\MangoPay\ReportRequest');
    }
    
    function test_ReportRequest_All_SortByCreationDate() {
        $pagination = new \MangoPay\Pagination(1, 1);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);
        
        $getAllReportRequests = $this->_api->Reports->GetAll($pagination, null, $sorting);

        $this->assertEqual(count($getAllReportRequests), 1);
        $this->assertIsA($getAllReportRequests[0], '\MangoPay\ReportRequest');
    }
}