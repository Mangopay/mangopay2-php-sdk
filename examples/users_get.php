<?php
// require include only one file
require_once '../MangoPaySDK/mangoPayApi.inc';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    
    // GET NATURAL USER: GET /users/natural/123456
    $naturalUserResult = $api->Users->GetNatural(990635);
    // display result on screen
    MangoPay\Logs::Debug('READ NATURAL USER', $naturalUserResult);
    
    // GET LEGAL USER: GET /users/legal/123456
    $legalUserResult = $api->Users->GetLegal(990612);
    // display result on screen
    MangoPay\Logs::Debug('READ LEGAL USER', $legalUserResult);
    
    // GET NATURAL USER GET /users/123456
    $userResult = $api->Users->Get(990612);
    // display result on screen
    MangoPay\Logs::Debug('READ USER', $userResult);
    
} catch (MangoPay\ResponseException $e) {
    
    MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Exception $e) {
    
    MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}