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
        'List bank accounts for user' => 'User_Users_ListSubEntity_BankAccount',
    ),
    'Wallets' => array(
        'Create wallet' => 'Wallet_Wallets_Create',
        'Get wallet' => 'Wallet_Wallets_Get',
        'Save wallet' => 'Wallet_Wallets_Save',
    ),
    'Transactions' => array(
        'List transactions for wallet' => 'Wallet_Wallets_ListSubEntity_Transaction',
    ),
    'Transfers' => array(
        'Create transfer' => 'Transfer_Transfers_Create',
        'Get transfer' => 'Transfer_Transfers_Get',
    ),
    'Pay-ins web card' => array(
        'Create pay-in web card' => 'PayIn_PayIns_Create_:CARD:WEB',
        'Get pay-in web card' => 'PayIn_PayIns_Get_:CARD:WEB',
    ),
    'Pay-outs bank wire' => array(
        'Create pay-out bank wire' => 'PayOut_PayOuts_Create_:BANK_WIRE',
        'Get pay-out bank wire' => 'PayOut_PayOuts_Get_:BANK_WIRE',
    ),
);

?>

<ul>
<?php
foreach ($GLOBALS['MangoPay_Demo_Menu'] as $moduleText => $subMenu) {
    
    echo '<li>' . $moduleText . '</li><ul>';
    foreach ($subMenu as $menuText => $file) {
        echo '<li><a href="index.php?module=' . $file . '" >' . $menuText . '</a></li>';
    }
    echo '</ul>';
}
?>
</ul>
