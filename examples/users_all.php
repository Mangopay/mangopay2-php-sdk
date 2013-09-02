<?php
// require include only one file
require_once '../MangoPaySDK/mangoPayApi.inc';

try {
    // create object to manage MangoPay API
    $api = new MangoPay\MangoPayApi();
    
    // GET USERS LIST: GET /users
    $pagination = new MangoPay\Pagination(1, 8);
    $users = $api->Users->GetAll($pagination);
    
    // display result on screen
    MangoPay\Logs::Debug('PAGINATION OBJECT', $pagination);
    MangoPay\Logs::Debug('LIST WITH USERS', $users);

} catch (MangoPay\ResponseException $e) {
    
    MangoPay\Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
    MangoPay\Logs::Debug('Message', $e->GetMessage());
    MangoPay\Logs::Debug('Details', $e->GetErrorDetails());
    
} catch (MangoPay\Exception $e) {
    
    MangoPay\Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
}