<?php
// require include only one file
require_once '../MangoPaySDK/mangoPayApi.inc';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->ClientID = 'example';
    $api->Config->ClientPassword = 'uyWsmnwMQyTnqKgi8Y35A3eVB7bGhqrebYqA1tL6x2vYNpGPiY';
    
    // CREATE NATURAL USER
    $naturalUser = new MangoPay\UserNatural();
    $naturalUser->Email = 'test_natural@testmangopay.com';
    $naturalUserResult = $api->Users->Create($naturalUser);
    // display result
    MangoPay\Logs::Debug('CREATED NATURAL USER', $naturalUserResult);
    
    // CREATE LEGAL USER
    $legalUser = new MangoPay\UserLegal();
    $legalUser->Name = 'Name Legal Test';
    $legalUser->LegalPersonType = 'BUSINESS';
    $legalUser->Email = 'legal@testmangopay.com';
    $legalUserResult = $api->Users->Create($legalUser);
    // display result
    MangoPay\Logs::Debug('CREATED LEGAL USER', $legalUserResult);
    
} catch (MangoPay\ResponseException $e) {
    
    MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Exception $e) {
    
    MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}


