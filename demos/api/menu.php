<?php

$GLOBALS['MangoPay_Demo_Menu'] = array(
    
    'Users' => array(
        'Create natural user' => 'UserNatural_Users_Create',
        'Create legal user' => 'UserLegal_Users_Create',
        'Get user' => 'User_Users_Get',
        'Get all users' => 'User_Users_All',
        'Save natural user' => 'UserNatural_Users_Save',
        'Save legal user' => 'UserLegal_Users_Save',
        'Save legal user' => 'UserLegal_Users_Save',
    ),
    'Bank accounts' => array(
        'Create bank account for user' => 'User_Users_CreateSubEntity_BankAccount',
        'Get bank account for user' => 'User_Users_GetSubEntity_BankAccount',
        'List bank accounts for user' => 'User_Users_ListSubEntity_GetBankAccounts',
    ),
    'Wallets' => array(
        'Create wallet' => 'Wallet_Wallets_Create',
        'Get wallet' => 'Wallet_Wallets_Get',
        'Save wallet' => 'Wallet_Wallets_Save',
        'List wallets for user' => 'User_Users_ListSubEntity_GetWallets',
    ),
    'Transactions' => array(
        'List transactions for wallet' => 'Wallet_Wallets_ListSubEntity_GetTransactions_FilterTransactions',
    ),
    'Transfers' => array(
        'Create transfer' => 'Transfer_Transfers_Create',
        'Get transfer' => 'Transfer_Transfers_Get',
    ),
    'Pay-ins' => array(
        'Create pay-in web card' => 'PayIn_PayIns_Create_:CARD:WEB',
        'Create pay-in direct card' => 'PayIn_PayIns_Create_:CARD:DIRECT',
        'Get pay-in' => 'PayIn_PayIns_Get',
    ),
    'Pay-outs' => array(
        'Create pay-out bank wire' => 'PayOut_PayOuts_Create_:BANK_WIRE',
        'Get pay-out bank wire' => 'PayOut_PayOuts_Get_:BANK_WIRE',
    ),
    'Refunds' => array(
        'Create refund for transfer' => 'Transfer_Transfers_CreateSubEntity_Refund',
        'Create refund for pay-in' => 'PayIn_PayIns_CreateSubEntity_Refund',
        'Get refund' => 'Refund_Refunds_Get',
    ),
    'Card registration' => array(
        'Create card registration' => 'CardRegistration_CardRegistrations_Create',
        'Get card registration' => 'CardRegistration_CardRegistrations_Get',
        'Update card registration' => 'CardRegistration_CardRegistrations_Save',
    ),
    'Card' => array(
        'Get card' => 'Card_Cards_Get',
    ),
    'Event' => array(
        'Get event' => 'Event_Events_All__FilterEvents',
    ),
    'KYC' => array(
        'Create document' => 'User_Users_CreateSubEntity_KycDocument',
        'Get document' => 'User_Users_GetSubEntity_KycDocument',
        'Save document' => 'User_Users_SaveSubEntity_KycDocument',
        'Create page from base64' => 'User_Users_CreateSubSubEntity_KycPage__KycDocument',
        'Create page from file' => 'User_Users_CreateKycPageByFile_KycPage__KycDocument',
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