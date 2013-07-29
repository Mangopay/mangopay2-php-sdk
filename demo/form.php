<?php
namespace MangoPay\Demo;
require_once '../src/mangoPayApi.inc';
require_once 'htmlHelper.php';

$module = @$_GET['module'];
if (!isset($module))
    return;

HtmlHelper::getHeader($module);

$details = explode('_', $module);
$entityName = @$details[0];
$subApiName = @$details[1];
$operation = @$details[2];
$subEntityName = @$details[3];
$entityId = (int)@$_POST['Id'];
$subEntityId = (int)@$_POST['IdSubEntity'];

if (isset($_POST['_postback']) && $_POST['_postback'] == '1') {

    try {
        $api = new \MangoPay\MangoPayApi();

//print '<pre>';print_r($_REQUEST);print '</pre>';
//$entity = HtmlHelper::getEntity($entityName);
//$apiResult = $entity;

        // special cases
        switch ($module) {
            case 'Wallet_Wallets_ListSubEntity_Transaction':
                $pagination = HtmlHelper::getEntity('Pagination', 0, true);
                $filter = HtmlHelper::getEntity('FilterTransactions', 0, true);
                $apiResult = $api->Wallets->Transactions($entityId, $pagination, $filter);
                break;
        }

        // normal cases
        if (!isset($apiResult)) switch ($operation) {
            case 'Create':
                $entity = HtmlHelper::getEntity($entityName);
                $apiResult = $api->$subApiName->Create($entity);
                break;
            case 'Get':
                $apiResult = $api->$subApiName->Get($entityId);
                break;
            case 'Save':
                $entity = HtmlHelper::getEntity($entityName, $entityId);
                $apiResult = $api->$subApiName->Save($entity);
                break;
            case 'All':
                $pagination = HtmlHelper::getEntity('Pagination');
                $apiResult = $api->$subApiName->All($pagination);
                print '<pre>';print_r($pagination);print '</pre>';
                break;

            case 'CreateSubEntity':
                $entity = HtmlHelper::getEntity($subEntityName);
                $methodName = 'Create'. $subEntityName;
                $apiResult = $api->$subApiName->$methodName($entityId, $entity);
                break;
            case 'GetSubEntity':
                $methodName = $subEntityName;
                $apiResult = $api->$subApiName->$methodName($entityId, $subEntityId);
                break;
            case 'ListSubEntity':
                $pagination = HtmlHelper::getEntity('Pagination');
                $methodName = $subEntityName . 's';
                $apiResult = $api->$subApiName->$methodName($entityId, $pagination);
                print '<pre>';print_r($pagination);print '</pre>';
                break;
        }
        
        print '<pre>';print_r($apiResult);print '</pre>';

    } catch (\MangoPay\ResponseException $e) {
        
        echo '<div style="color: red;">\MangoPay\ResponseException: Code: ' . $e->getCode();
        echo '<br/>Message: ' . $e->getMessage();
        
       $details = $e->GetErrorDetails();
        if (!is_null($details))
            echo '<br/><br/>Details: '; print_r($details);
        echo '</div>';

    } catch (\MangoPay\Exception $e) {
        
        echo '<div style="color: red;">\MangoPay\Exception: ' . $e->getMessage() . '</div>';
        
    }

} else {
    HtmlHelper::renderForm($entityName, $operation, $subEntityName, $module);
}
