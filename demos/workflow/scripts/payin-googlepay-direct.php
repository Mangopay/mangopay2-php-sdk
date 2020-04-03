<?php
$PayInGooglePay = new \MangoPay\PayIn();
$PayInGooglePay->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayInGooglePay->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayInGooglePay->DebitedFunds = new \MangoPay\Money();
$PayInGooglePay->DebitedFunds->Currency = "EUR";
$PayInGooglePay->DebitedFunds->Amount = 599;
$PayInGooglePay->Fees = new \MangoPay\Money();
$PayInGooglePay->Fees->Currency = "EUR";
$PayInGooglePay->Fees->Amount = 0;
$PayInGooglePay->PaymentDetails = new MangoPay\PayInPaymentDetailsGooglePay();
$PayInGooglePay->PaymentDetails->PaymentData = new \MangoPay\PaymentData();
$PayInGooglePay->PaymentDetails->PaymentData->TransactionId = 'placeholder';
$PayInGooglePay->PaymentDetails->PaymentData->Network = 'placeholder';
$PayInGooglePay->PaymentDetails->PaymentData->TokenData = 'placeholder';

$PayInGooglePay->StatementDescriptor = 'Mar2020';
$PayInGooglePay->Tag = 'custom meta';
$result = $mangoPayApi->PayIns->Create($PayInGooglePay);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardDirect"] = $result->Id;