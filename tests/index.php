<?php

require_once '../src/mangoPayApi.inc';

try {
    
    $api = new MangoPay\MangoPayApi();
    $pagination = new MangoPay\Pagination(1, 12);
    
    //$result = $api->Wallets->Transactions(384496);
    
    
    //die('sdfsdf');
    // CREATE CLIENT
    /*$api = new MangoPay\MangoPayApi();
    $result = $api->Clients->Create('testclientid', 'Test-API');
    print '<pre>';print_r($result);print '</pre>';*/
    
    
    // GET DATA FROR STRONG AUTH
    /*$api = new MangoPay\MangoPayApi();
    $oauth = $api->OAuth->Token();
    print '<pre>';print_r($oauth);print '</pre>';*/
        
    // CREATE NATURAL USER
    /*$createUser = new MangoPay\UserNatural();
    //$createUser = new MangoPay\UserLegal();
    $createUser->Email = 'test@testmangopay.com';
    $api = new MangoPay\MangoPayApi();
    $user = $api->Users->Create($createUser);
    print "<pre>"; print_r($user);print "</pre>";*/
    
    // CREATE LEGAL USER
    /*$createUser = new MangoPay\UserLegal();
    $createUser->Name = 'Name Legal Test';
    $createUser->LegalPersonType = 'BUSINESS';
    $createUser->Email = 'legal@testmangopay.com';
    $api = new MangoPay\MangoPayApi($result->access_token, $result->token_type);
    $user = $api->Users->Create($createUser);
    print "<pre>"; print_r($user);print "</pre>";*/
    
    // GET ALL USERS
    //$result = $api->Users->All($pagination); // 384372
    
    // SAVE USER
    /*$user = new MangoPay\UserNatural(990646);
    $user->Email = 'lukasz3@test.com';
    $user->FirstName = 'Lukasz';
    $user->LastName = 'Lukasz Last Name2';
    $api = new MangoPay\MangoPayApi();
    $user2 = $api->Users->Save($user);
    print "<pre>"; print_r($user2);print "</pre>";*/
    
    // GET NATURAL USER
    /*$api = new MangoPay\MangoPayApi();
    $result = $api->Users->Get('990612');
    print "<pre>"; print_r($result);print "</pre>";*/
    
    /*$bankAccount = new MangoPay\BankAccount();
    $bankAccount->Type = 'IBAN';
    $bankAccount->OwnerName = 'Owner name test';
    $bankAccount->OwnerAddress = 'address test';
    $bankAccount->IBAN = 'AD12 0001 2030 2003 5910 0100';
    $bankAccount->BIC = 'BINAADADXXX';
    $result = $api->Users->CreateBankAccount('990611', $bankAccount);
    print "<pre>"; print_r($result);print "</pre>";*/
    
    //  GET ALL BANK ACCOUNTS
    /*$api = new MangoPay\MangoPayApi();
    $result = $api->Users->BankAccounts('990611');
    print "<pre>"; print_r($result);print "</pre>";*/
    
    // GET ALL USERS
    $result = $api->Users->All();
    print "<pre>"; print_r($result);print "</pre>";
    
    //  GET ALL Wallets
//    $result = $api->Users->Wallets('990611');
//    print "<pre>"; print_r($result);print "</pre>";
    
    /*$card = $api->Users->Get;
    print "<pre>"; print_r($card);print "</pre>";*/
       
    // GET LEGAL USER
    /*$api = new MangoPay\MangoPayApi($oauth);
    $user = $api->Users->GetLegal('990612');
    print "<pre>"; print_r($user);print "</pre>";*/
    
    // CREATE WALLET
    /*$newWallet = new MangoPay\Wallet();
    $newWallet->Owners = array(990611);
    $newWallet->Currency = 'EUR';
    $newWallet->Description = 'WALLET IN EUR';
    $result = $api->Wallets->Create($newWallet);*/
    
    // SAVE WALLET
    /*$wallet = new MangoPay\Wallet('384496');
    $wallet->Description = 'WALLET IN USD';
    $api = new MangoPay\MangoPayApi();
    $wallet = $api->Wallets->Save($wallet);
    print "<pre>"; print_r($wallet);print "</pre>";*/
    
    // GET WALLET
    /**$api = new MangoPay\MangoPayApi();
    $wallet = $api->Wallets->Get('1020365');
    print "<pre>"; print_r($wallet);print "</pre>";*/
    
    // CREATE PAY-IN 
    /*$api = new MangoPay\MangoPayApi();
    $payIn = new MangoPay\PayIn();
    $payIn->CreditedWalletId = 384496;
    $payIn->Payment = new \MangoPay\Card();
    $payIn->Payment->CardType = 'AMEX';
    $payIn->Payment->ReturnURL = 'https://teste.com';
    $payIn->Execution = new \MangoPay\Web();
    $payIn->Execution->Culture = 'fr';
    $result = $api->PayIns->Create($payIn);*/
    
    
    // GET PAY-IN
    /*$api = new MangoPay\MangoPayApi();
    $result = $api->PayIns->Get('990685');
    print "<pre>"; print_r($result);print "</pre>";*/
    
    // CREATE PAY-OUT 
    /*$api = new MangoPay\MangoPayApi();
    $payOut = new MangoPay\PayOut();
    $payOut->DebitedWalletID = 990650;
    $payOut->MeanOfPayment = new MangoPay\BankWirePayOut();
    $payOut->MeanOfPayment->BankAccountId = 121212;
    $result = $api->PayOuts->Create($payOut);
    print "<pre>"; print_r($result);print "</pre>";*/
    
    
    //print "<pre>"; print_r($result);print "</pre>";
} catch (MangoPay\ResponseException $e) {
    print "<pre>"; print_r('MangoPay\ResponseException Code: ' . $e->GetCode() . ' Message: ' . $e->GetMessage() );print "</pre>";
    print '<pre>';print_r($e->GetErrorDetails());print '</pre>';
}
