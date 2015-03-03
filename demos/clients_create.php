<?php
// require include only one file
require_once '../vendor/autoload.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();

    // CREATE CLIENT: POST /api/clients/
    // your Client ID; simulated here to be unique; must be lowercase alphanum 4-20 chars
    $testUniqueClientId = substr(md5(microtime()), 0, 20);
    $client = $api->Clients->Create($testUniqueClientId, 'Test Client Name', 'test.email@sample.org');

    // display result on screen
    MangoPay\Tools\Logs::Debug('CREATED CLIENT', $client);

} catch (MangoPay\Types\Exceptions\ResponseException $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\ResponseException Code', $e->GetCode());
    MangoPay\Tools\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Tools\Logs::Debug('Details', $e->GetErrorDetails());

} catch (MangoPay\Types\Exceptions\Exception $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\Exception Message', $e->GetMessage());
}
