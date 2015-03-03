<?php
// require include only one file
require_once '../vendor/autoload.php';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    // use test client credentails (REPLACE IT BY YOUR CLIENT ONES!)
    $api->Config->TemporaryFolder = __dir__;
    $api->Config->ClientID = 'sdk_example';
    $api->Config->ClientPassword = 'Vfp9eMKSzGkxivCwt15wE082pTTKsx90vBenc9hjLsf5K46ciF';

    // GET NATURAL USER: GET /users/natural/4991600
    $naturalUserResult = $api->Users->GetNatural(4991600);
    // display result on screen
    MangoPay\Tools\Logs::Debug('READ NATURAL USER', $naturalUserResult);

    // GET LEGAL USER: GET /users/legal/4991601
    $legalUserResult = $api->Users->GetLegal(4991601);
    // display result on screen
    MangoPay\Tools\Logs::Debug('READ LEGAL USER', $legalUserResult);

    // GET NATURAL USER GET /users/4991600
    $userResult = $api->Users->Get(4991600);
    // display result on screen
    MangoPay\Tools\Logs::Debug('READ USER', $userResult);

} catch (MangoPay\Types\Exceptions\ResponseException $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\ResponseException Code', $e->GetCode());
    MangoPay\Tools\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Tools\Logs::Debug('Details', $e->GetErrorDetails());

} catch (MangoPay\Types\Exceptions\Exception $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\Exception Message', $e->GetMessage());
}
