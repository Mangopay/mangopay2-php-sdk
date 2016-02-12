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
	
    // GET USERS LIST: GET /users
    $pagination = new MangoPay\Pagination(1, 8);
    $users = $api->Users->GetAll($pagination);
    
    // display result on screen
    MangoPay\Libraries\Logs::Debug('PAGINATION OBJECT', $pagination);
    MangoPay\Libraries\Logs::Debug('LIST WITH USERS', $users);

} catch (MangoPay\Libraries\ResponseException $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Libraries\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Libraries\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Libraries\Exception $e) {
    
    MangoPay\Libraries\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}