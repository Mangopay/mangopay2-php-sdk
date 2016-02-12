<?php
// require include only one file
require_once '../vendor/autoload.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->ClientId = 'sdk_example';
    $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';
    $api->Config->TemporaryFolder = '/a/writable/folder/somewhere/ideally-out-of-reach-of-your-root/';
    
    // GET NATURAL USER: GET /users/natural/4991600
    $naturalUserResult = $api->Users->GetNatural(4991600);
    // display result on screen
    MangoPay\Libraries\Logs::Debug('READ NATURAL USER', $naturalUserResult);
    
    // GET LEGAL USER: GET /users/legal/4991601
    $legalUserResult = $api->Users->GetLegal(4991601);
    // display result on screen
    MangoPay\Libraries\Logs::Debug('READ LEGAL USER', $legalUserResult);
    
    // GET NATURAL USER GET /users/4991600
    $userResult = $api->Users->Get(4991600);
    // display result on screen
    MangoPay\Libraries\Logs::Debug('READ USER', $userResult);
    
} catch (MangoPay\Libraries\ResponseException $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Libraries\Exception $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}