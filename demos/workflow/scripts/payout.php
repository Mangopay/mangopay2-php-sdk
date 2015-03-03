<?php
$PayOut = new \MangoPay\Entities\PayOut();
$PayOut->AuthorId = $_SESSION["MangoPayDemo"]["UserLegal"];
$PayOut->DebitedWalletID = $_SESSION["MangoPayDemo"]["WalletForLegalUser"];
$PayOut->DebitedFunds = new \MangoPay\Types\Money();
$PayOut->DebitedFunds->Currency = "EUR";
$PayOut->DebitedFunds->Amount = 610;
$PayOut->Fees = new \MangoPay\Types\Money();
$PayOut->Fees->Currency = "EUR";
$PayOut->Fees->Amount = 125;
$PayOut->PaymentType = "BANK_WIRE";
$PayOut->MeanOfPaymentDetails = new \MangoPay\Types\PayOutPaymentDetailsBankWire();
$PayOut->MeanOfPaymentDetails->BankAccountId = $_SESSION["MangoPayDemo"]["BankAccount"];
$result = $mangoPayApi->PayOuts->Create($PayOut);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["PayOut"] = $result->Id;
