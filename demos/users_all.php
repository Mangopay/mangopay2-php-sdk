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

    // GET USERS LIST: GET /users
    $pagination = new MangoPay\Types\Pagination(1, 8);
    $users = $api->Users->GetAll($pagination);

    // display result on screen
    MangoPay\Tools\Logs::Debug('PAGINATION OBJECT', $pagination);
    MangoPay\Tools\Logs::Debug('LIST WITH USERS', $users);

} catch (MangoPay\Types\Exceptions\ResponseException $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\ResponseException Code', $e->GetCode());
    MangoPay\Tools\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Tools\Logs::Debug('Details', $e->GetErrorDetails());

} catch (MangoPay\Types\Exceptions\Exception $e) {

    MangoPay\Tools\Logs::Debug('MangoPay\Types\Exceptions\Exception Message', $e->GetMessage());
}
