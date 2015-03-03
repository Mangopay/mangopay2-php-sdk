<?php

$GLOBALS['MangoPay_Demo_Menu'] = array(

    'Users' => array(
        'Create natural user' => 'Entities\\UserNatural_Users_Create',
        'Create legal user' => 'Entities\\UserLegal_Users_Create',
        'Get user' => 'Entities\\User_Users_Get',
        'Get all users' => 'Entities\\User_Users_All',
        'Save natural user' => 'Entities\\UserNatural_Users_Save',
        'Save legal user' => 'Entities\\UserLegal_Users_Save',
        'Save legal user' => 'Entities\\UserLegal_Users_Save',
    ),
    'Bank accounts' => array(
        'Create IBAN account' => 'Entities\\User_Users_CreateSubEntity_Entities\\BankAccount_:IBAN',
        'Create GB account' => 'Entities\\User_Users_CreateSubEntity_Entities\\BankAccount_:GB',
        'Create US account' => 'Entities\\User_Users_CreateSubEntity_Entities\\BankAccount_:US',
        'Create CA account' => 'Entities\\User_Users_CreateSubEntity_Entities\\BankAccount_:CA',
        'Create OTHER account' => 'Entities\\User_Users_CreateSubEntity_Entities\\BankAccount_:OTHER',
        'Get bank account for user' => 'Entities\\User_Users_GetSubEntity_Entities\\BankAccount',
        'List bank accounts for user' => 'Entities\\User_Users_ListSubEntity_GetBankAccounts__$Sort',
    ),
    'Wallets' => array(
        'Create wallet' => 'Entities\\Wallet_Wallets_Create',
        'Get wallet' => 'Entities\\Wallet_Wallets_Get',
        'Save wallet' => 'Entities\\Wallet_Wallets_Save',
        'List wallets for user' => 'Entities\\User_Users_ListSubEntity_GetWallets__$Sort',
    ),
    'Transactions' => array(
        'List transactions for user' => 'Entities\\User_Users_ListSubEntity_GetTransactions_Tools\\FilterTransactions__$Sort',
        'List transactions for wallet' => 'Entities\\Wallet_Wallets_ListSubEntity_GetTransactions_Tools\\FilterTransactions__$Sort',
    ),
    'Transfers' => array(
        'Create transfer' => 'Entities\\Transfer_Transfers_Create',
        'Get transfer' => 'Entities\\Transfer_Transfers_Get',
    ),
    'Pay-ins' => array(
        'Create pay-in web card' => 'Entities\\PayIn_PayIns_Create_:CARD:WEB',
        'Create pay-in direct card' => 'Entities\\PayIn_PayIns_Create_:CARD:DIRECT',
        'Create pay-in direct pre-authorized' => 'Entities\\PayIn_PayIns_Create_:PREAUTHORIZED:DIRECT',
        'Create pay-in direct bank wire' => 'Entities\\PayIn_PayIns_Create_:BANK_WIRE:DIRECT',
        'Create pay-in direct debit web' => 'Entities\\PayIn_PayIns_Create_:DIRECT_DEBIT:WEB',
        'Get pay-in' => 'Entities\\PayIn_PayIns_Get',
    ),
    'Pay-outs' => array(
        'Create pay-out bank wire' => 'Entities\\PayOut_PayOuts_Create_:BANK_WIRE',
        'Get pay-out bank wire' => 'Entities\\PayOut_PayOuts_Get_:BANK_WIRE',
    ),
    'Refunds' => array(
        'Create refund for transfer' => 'Entities\\Transfer_Transfers_CreateSubEntity_Refund',
        'Create refund for pay-in' => 'Entities\\PayIn_PayIns_CreateSubEntity_Refund',
        'Get refund' => 'Entities\\Refund_Refunds_Get',
    ),
    'Card registration' => array(
        'Create card registration' => 'Entities\\CardRegistration_CardRegistrations_Create',
        'Get card registration' => 'Entities\\CardRegistration_CardRegistrations_Get',
        'Update card registration' => 'Entities\\CardRegistration_CardRegistrations_Save',
    ),
    'Card pre-authorization' => array(
        'Create pre-authorization' => 'Entities\\CardPreAuthorization_CardPreAuthorizations_Create',
        'Get pre-authorization' => 'Entities\\CardPreAuthorization_CardPreAuthorizations_Get',
        'Update pre-authorization' => 'Entities\\CardPreAuthorization_CardPreAuthorizations_Save',
    ),
    'Card' => array(
        'Get card' => 'Entities\\Card_Cards_Get',
        'Save card' => 'Entities\\Card_Cards_Save',
        'List cards for user' => 'Entities\\User_Users_ListSubEntity_GetCards__$Sort',
    ),
    'Event' => array(
        'List events' => 'Entities\\Event_Events_All__Tools\\FilterEvents',
    ),
    'Hooks' => array(
        'Create hook' => 'Entities\\Hook_Hooks_Create',
        'Get hook' => 'Entities\\Hook_Hooks_Get',
        'Save hook' => 'Entities\\Hook_Hooks_Save',
        'List of hooks' => 'Entities\\Hook_Hooks_All',
    ),
    'KYC' => array(
        'Create document' => 'Entities\\User_Users_CreateSubEntity_Entities\\KycDocument',
        'Get document' => 'Entities\\User_Users_GetSubEntity_Entities\\KycDocument',
        'Save document' => 'Entities\\User_Users_SaveSubEntity_Entities\\KycDocument',
        'Create page from base64' => 'Entities\\User_Users_CreateSubSubEntity_KycPage__Entities\\KycDocument',
        'Create page from file' => 'Entities\\User_Users_CreateKycPageByFile_KycPage__Entities\\KycDocument',
        'List KYC documents for user' => 'Entities\\User_Users_ListSubEntity_GetKycDocuments__$Sort',
        'List all KYC documents' => 'Entities\\Entities\\KycDocument_KycDocuments_All___$Sort',
    ),
);

?>

<div id="menu">
<?php

$moduleIndex = 0;
$selectedModuleIndex = -1;

foreach ($GLOBALS['MangoPay_Demo_Menu'] as $moduleText => $subMenu) {

    echo '<h3>' . $moduleText . '</h3><ul>';
    foreach ($subMenu as $menuText => $file) {
        echo '<li><a href="index.php?module=' . $file . '" >' . $menuText . '</a></li>';
        if( @$_GET['module'] == $file ) $selectedModuleIndex = $moduleIndex;
    }
    echo '</ul>';

    $moduleIndex ++;
}

?>
</div>
<script type="text/javascript">var selectedModuleIndex = <?php echo $selectedModuleIndex ?>; </script>
