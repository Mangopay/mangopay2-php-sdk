<?php
$CardPreAuthorization = new \MangoPay\CardPreAuthorization();
$CardPreAuthorization->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$CardPreAuthorization->DebitedFunds = new \MangoPay\Money();
$CardPreAuthorization->DebitedFunds->Currency = "EUR";
$CardPreAuthorization->DebitedFunds->Amount = 1500;
$CardPreAuthorization->SecureMode = "DEFAULT";
$CardPreAuthorization->CardId = $_SESSION["MangoPayDemo"]["Card"];
$CardPreAuthorization->SecureModeReturnURL = "http" . (isset($_SERVER['HTTPS']) ? "s" : null) . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["SCRIPT_NAME"] . "?stepId=" . ($stepId + 1);
$CardPreAuthorization->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
$CardPreAuthorization->BrowserInfo = new \MangoPay\BrowserInfo();
$CardPreAuthorization->BrowserInfo->AcceptHeader = "text/html, application/xhtml+xml, application/xml;q=0.9, /;q=0.8";
$CardPreAuthorization->BrowserInfo->JavaEnabled = true;
$CardPreAuthorization->BrowserInfo->Language = "FR-FR";
$CardPreAuthorization->BrowserInfo->ColorDepth = 4;
$CardPreAuthorization->BrowserInfo->ScreenHeight = 1800;
$CardPreAuthorization->BrowserInfo->ScreenWidth = 400;
$CardPreAuthorization->BrowserInfo->TimeZoneOffset = 60;
$CardPreAuthorization->BrowserInfo->UserAgent = "Mozilla/5.0 (iPhone; CPU iPhone OS 13_6_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148";
$CardPreAuthorization->BrowserInfo->JavascriptEnabled = true;
$result = $mangoPayApi->CardPreAuthorizations->Create($CardPreAuthorization);


//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PreAuth"] = $result->Id;
if ($result->SecureModeNeeded && $result->Status != \MangoPay\CardPreAuthorizationStatus::Failed) {
	$nextButton = array("url" => $result->SecureModeRedirectURL, "text" => "Go to 3DS payment page");
}