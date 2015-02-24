<?php
// require include only one file
require_once '../MangoPaySDK/mangoPayApi.inc';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->ClientID = 'sdk_example';
    $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';
    
    // GET NATURAL USER: GET /users/natural/4991600
    $naturalUserResult = $api->Users->GetNatural(4991600);
    // display result on screen
    MangoPay\Logs::Debug('READ NATURAL USER', $naturalUserResult);
    
    // GET LEGAL USER: GET /users/legal/4991601
    $legalUserResult = $api->Users->GetLegal(4991601);
    // display result on screen
    MangoPay\Logs::Debug('READ LEGAL USER', $legalUserResult);
    
    // GET NATURAL USER GET /users/4991600
    $userResult = $api->Users->Get(4991600);
    // display result on screen
    MangoPay\Logs::Debug('READ USER', $userResult);
    
} catch (MangoPay\ResponseException $e) {
    
    MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Exception $e) {
    
    MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}