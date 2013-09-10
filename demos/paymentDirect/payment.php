<?php
session_start();
require_once '../../MangoPaySDK/mangoPayApi.inc';

// check error message from payline page. If exist display error message and terminate the script
if (isset($_GET['errorCode'])) {
    die('<div style="color:red;">Error code from payline: ' . $_GET['errorCode'] .'<div>');
}

// protection to double call page. If session is not set display error message and terminate the script
if (!isset($_SESSION['amount'])) {
    die('<div style="color:red;">Wrong data - session is not set<div>');
}

// create instance of MangoPayApi
$mangoPayApi = new \MangoPay\MangoPayApi();

try {
    
    // update register card with registration data from Payline service
    $cardRegister = $mangoPayApi->CardRegistrations->Get($_SESSION['cardRegisterId']);
    $cardRegister->RegistrationData = 'data=' . $_GET['data'];
    $updatedCardRegister = $mangoPayApi->CardRegistrations->Update($cardRegister);

    // get created virtual card object
    $card = $mangoPayApi->Cards->Get($updatedCardRegister->CardId);
    
    // create temporary wallet for user
    $wallet = new \MangoPay\Wallet();
    $wallet->Owners = array( $updatedCardRegister->UserId );
    $wallet->Currency = $_SESSION['currency'];
    $wallet->Description = 'Temporary wallet for payment demo';
    $createdWallet = $mangoPayApi->Wallets->Create($wallet);

    // create pay-in CARD DIRECT
    $payIn = new \MangoPay\PayIn();
    $payIn->CreditedWalletId = $createdWallet->Id;
    $payIn->AuthorId = $updatedCardRegister->UserId;
    $payIn->DebitedFunds = new \MangoPay\Money();
    $payIn->DebitedFunds->Amount = $_SESSION['amount'];
    $payIn->DebitedFunds->Currency = $_SESSION['currency'];
    $payIn->Fees = new \MangoPay\Money();
    $payIn->Fees->Amount = $_SESSION['fees'];
    $payIn->Fees->Currency = $_SESSION['currency'];
    
    // payment type as CARD
    $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
    if ($card->CardType == 'CB' || $card->CardType == 'VISA' || $card->CardType == 'MASTERCARD')
        $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
    elseif ($card->CardType == 'AMEX')
        $payIn->PaymentDetails->CardType = 'AMEX';
    
    // execution type as DIRECT
    $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
    $payIn->ExecutionDetails->CardId = $card->Id;
    $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
    // create Pay-In
    $createdPayIn = $mangoPayApi->PayIns->Create($payIn);
    
    // if created Pay-in object has status SUCCEEDED it's mean that all is fine
    if ($createdPayIn->Status == 'SUCCEEDED') {
        print '<div style="color:green;">'.
                    'Pay-In has been created successfully. '
                    .'Pay-In Id = ' . $createdPayIn->Id 
                    . ', Wallet Id = ' . $createdWallet->Id 
                . '</div>';
    }
    else {
        // if created Pay-in object has status different than SUCCEEDED 
        // that occurred error and display error message
        print '<div style="color:red;">'.
                    'Pay-In has been created with status: ' 
                    . $createdPayIn->Status . ' (result code: '
                    . $createdPayIn->ResultCode . ')'
                .'</div>';
    }

} catch (\MangoPay\ResponseException $e) {
    
    print '<div style="color: red;">'
                .'\MangoPay\ResponseException: Code: ' 
                . $e->getCode() . '<br/>Message: ' . $e->getMessage()
                .'<br/><br/>Details: '; print_r($e->GetErrorDetails())
        .'</div>';
}

// clear data in session to protect before double call
$_SESSION = array();