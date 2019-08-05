<?php
$PayInApplePay = new \MangoPay\PayInApple();
$PayInApplePay->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayInApplePay->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayInApplePay->DebitedFunds = new \MangoPay\Money();
$PayInApplePay->DebitedFunds->Currency = "EUR";
$PayInApplePay->DebitedFunds->Amount = 599;
$PayInApplePay->Fees = new \MangoPay\Money();
$PayInApplePay->Fees->Currency = "EUR";
$PayInApplePay->Fees->Amount = 0;
$PayInApplePay->PaymentData = new \MangoPay\PaymentData();
$PayInApplePay->PaymentData->TransactionId = 'askldjasljdlasjdljasldasjldk';
$PayInApplePay->PaymentData->Network = 'VISA';
$PayInApplePay->PaymentData->TokenData = 'asljdlasdkalsdklsjad';

$PayInApplePay->StatementDescriptor = 'Mar2019';
$PayInApplePay->Tag = 'custom meta';
$result = $mangoPayApi->PayInsApplePay->Create($PayInApplePay);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardDirect"] = $result->Id;