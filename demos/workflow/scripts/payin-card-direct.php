<?php
$PayIn = new \MangoPay\PayIn();
$PayIn->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayIn->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayIn->PaymentType = \MangoPay\PayInPaymentType::Card;
$PayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
$PayIn->DebitedFunds = new \MangoPay\Money();
$PayIn->DebitedFunds->Currency = "EUR";
$PayIn->DebitedFunds->Amount = 599;
$PayIn->Fees = new \MangoPay\Money();
$PayIn->Fees->Currency = "EUR";
$PayIn->Fees->Amount = 0;
$PayIn->ExecutionType = \MangoPay\PayInExecutionType::Direct;
$PayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
$PayIn->ExecutionDetails->SecureModeReturnURL = "http" . (isset($_SERVER['HTTPS']) ? "s" : null) . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"] . "?stepId=" . ($stepId + 1);
$PayIn->ExecutionDetails->CardId = $_SESSION["MangoPayDemo"]["Card"];
$PayIn->PaymentDetails->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
$PayIn->PaymentDetails->BrowserInfo = new \MangoPay\BrowserInfo();
$PayIn->PaymentDetails->BrowserInfo->AcceptHeader = "text/html, application/xhtml+xml, application/xml;q=0.9, /;q=0.8";
$PayIn->PaymentDetails->BrowserInfo->JavaEnabled = true;
$PayIn->PaymentDetails->BrowserInfo->Language = "FR-FR";
$PayIn->PaymentDetails->BrowserInfo->ColorDepth = 4;
$PayIn->PaymentDetails->BrowserInfo->ScreenHeight = 1800;
$PayIn->PaymentDetails->BrowserInfo->ScreenWidth = 400;
$PayIn->PaymentDetails->BrowserInfo->TimeZoneOffset = 60;
$PayIn->PaymentDetails->BrowserInfo->UserAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148";
$PayIn->PaymentDetails->BrowserInfo->JavascriptEnabled = true;
$result = $mangoPayApi->PayIns->Create($PayIn);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardDirect"] = $result->Id;
if ($result->ExecutionDetails->SecureModeNeeded && $result->Status != \MangoPay\PayInStatus::Failed) {
	$nextButton = array("url" => $result->ExecutionDetails->SecureModeRedirectURL, "text" => "Go to 3DS payment page");
}