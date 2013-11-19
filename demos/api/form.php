<?php
namespace MangoPay\Demo;
require_once '../../MangoPaySDK/mangoPayApi.inc';
require_once 'htmlHelper.php';
require_once 'config.php';

$module = @$_GET['module'];
if (!isset($module))
    return;

HtmlHelper::getHeader($module);

$details = explode('_', $module);
$entityName = @$details[0];
$subApiName = @$details[1];
$operation = @$details[2];
$subEntityName = @$details[3];
$filterName = @$details[4];
$entityId = (int)@$_POST['Id'];
$subEntityId = (int)@$_POST['IdSubEntity'];

if (isset($_POST['_postback']) && $_POST['_postback'] == '1') {

    try {
        $api = new \MangoPay\MangoPayApi();
        $api->Config->ClientId = MangoPayDemo_ClientId;
        $api->Config->ClientPassword = MangoPayDemo_ClientPassword;
        $api->Config->TemporaryFolder = MangoPayDemo_TemporaryFolder;

        // special cases
        switch ($module) {
            case 'Wallet_Wallets_ListSubEntity_GetTransaction':
                $pagination = HtmlHelper::getEntity('Pagination', 0, true);
                $filter = HtmlHelper::getEntity('FilterTransactions', 0, true);
                $apiResult = $api->Wallets->GetTransactions($entityId, $pagination, $filter);
                break;
        }

        // normal cases
        if (!isset($apiResult))
        {
            switch ($operation) {
                case 'Create':
                    $entity = HtmlHelper::getEntity($entityName);
                    $apiResult = $api->$subApiName->Create($entity);
                    break;
                case 'Get':
                    $apiResult = $api->$subApiName->Get($entityId);
                    break;
                case 'Save':
                    $entity = HtmlHelper::getEntity($entityName, $entityId);
                    $apiResult = $api->$subApiName->Update($entity);
                    break;
                case 'All':
                    $pagination = HtmlHelper::getEntity('Pagination');
                    if (isset($filterName) && $filterName != "")
                        $filter = HtmlHelper::getEntity($filterName);
                    $apiResult = $api->$subApiName->GetAll($pagination, $filter);
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
                    $methodName = $subEntityName;
                    $filter = null;
                    if (isset($filterName) && $filterName != "")
                        $filter = HtmlHelper::getEntity($filterName);
                    $apiResult = $api->$subApiName->$methodName($entityId, $pagination, $filter);
                    print '<pre>';print_r($pagination);print '</pre>';
                    break;
            }
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
    HtmlHelper::renderForm($entityName, $operation, $subEntityName, $filterName);
}
