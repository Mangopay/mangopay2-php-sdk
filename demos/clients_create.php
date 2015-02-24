<?php
// require include only one file
require_once '../MangoPaySDK/mangoPayApi.inc';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    
    // CREATE CLIENT: POST /api/clients/
    // your Client ID; simulated here to be unique; must be lowercase alphanum 4-20 chars
    $testUniqueClientId = substr(md5(microtime()), 0, 20);
    $client = $api->Clients->Create($testUniqueClientId, 'Test Client Name', 'test.email@sample.org');
    
    // display result on screen
    MangoPay\Logs::Debug('CREATED CLIENT', $client);
    
} catch (MangoPay\ResponseException $e) {
    
    MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Exception $e) {
    
    MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}