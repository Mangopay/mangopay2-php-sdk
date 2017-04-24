<?php
// This is a very basic example of a file you could put on your server and with a daily cron, and get it to email you a report of all the successful transactions from the previous 24 hours.

// require include only one file
require_once '../vendor/autoload.php';

function getReportAndEmail($reportId) {
	global $api;
	$getReportRequest = $api->Reports->Get($reportId);
	if ($getReportRequest->Status=="PENDING") {
		
		sleep(1); #TODO use the reporting `CallbackURL` functionality instead of this!
		return getReportAndEmail($reportId);
		
	}elseif($getReportRequest->Status=="READY_FOR_DOWNLOAD") {
			
		mail("reporting_team@mycompany.com", "Yesterday's successful transaction report", "The report can be downloaded from ".$getReportRequest->DownloadURL.". Note that this link will expire in 24 hours.");
		return true;

	}else{
		die("There was an error...");
	}
	
}

try {

  // create object to manage MangoPay API
  $api = new MangoPay\MangoPayApi();
  // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
  $api->Config->ClientId = 'sdk_example';
  $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';
  $api->Config->TemporaryFolder = '/a/writable/folder/somewhere/ideally-out-of-reach-of-your-root/';


  $reportRequest = new \MangoPay\ReportRequest();
  $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
  $reportRequest->Filters = new \MangoPay\FilterReports();
  $reportRequest->Filters->ResultCode = array("000000");
  $reportRequest->Filters->Status = array("SUCCEEDED");
  $reportRequest->Filters->BeforeDate = time();
  $reportRequest->Filters->AfterDate = strtotime("-1 day");
  $reportRequest->Filters->Type = array("PAYIN");
  $reportRequest->Columns = array("CreationDate:ISO", "ExecutionDate:ISO", "AuthorId", "CreditedWalletId", "Type", "Nature");

  $createReportRequest = $mangoPayApi->Reports->Create($reportRequest);	

  getReportAndEmail($createReportRequest->Id);
  
} catch (MangoPay\Libraries\ResponseException $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Libraries\Exception $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}
