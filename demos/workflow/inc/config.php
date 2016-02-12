<?php
require_once '../../vendor/autoload.php';
require_once 'inc/mockStorage.php';

define("MangoPayAPIClientId", empty($_SESSION["MangoPayDemoConfig"]["ClientId"]) ? "demo" : $_SESSION["MangoPayDemoConfig"]["ClientId"]);
define("MangoPayAPIPassword", empty($_SESSION["MangoPayDemoConfig"]["Password"]) ? "SRbaqf9kwpjOxAYtE9tVFVBWAh2waeF7TX4TEcZ4jVFKbm1uaD" : $_SESSION["MangoPayDemoConfig"]["Password"]);

$mangoPayApi = new \MangoPay\MangoPayApi();
$mangoPayApi->Config->ClientId = MangoPayAPIClientId;
$mangoPayApi->Config->ClientPassword = MangoPayAPIPassword;
//$mangoPayApi->Config->TemporaryFolder = __dir__;
$mangoPayApi->OAuthTokenManager->RegisterCustomStorageStrategy(new \MangoPay\DemoWorkflow\MockStorageStrategy());