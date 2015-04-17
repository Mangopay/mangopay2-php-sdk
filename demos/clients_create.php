<?php
// require include only one file
require_once '../MangoPay/Autoloader.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    
    // CREATE CLIENT: POST /api/clients/
    // your Client ID; simulated here to be unique; must be lowercase alphanum 4-20 chars
    $testUniqueClientId = substr(md5(microtime()), 0, 20);
    $client = $api->Clients->Create($testUniqueClientId, 'Test Client Name', 'test.email@sample.org');
    
    // display result on screen
    MangoPay\Libraries\Logs::Debug('CREATED CLIENT', $client);
    
} catch (MangoPay\Libraries\ResponseException $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Libraries\Exception $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}