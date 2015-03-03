<?php
$PayIn = new \MangoPay\Entities\PayIn();
$PayIn->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$PayIn->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$PayIn->PaymentType = "CARD";
$PayIn->PaymentDetails = new \MangoPay\Types\PayInPaymentDetailsPreAuthorized();
$PayIn->PaymentDetails->PreauthorizationId = $_SESSION["MangoPayDemo"]["PreAuth"];
$PayIn->DebitedFunds = new \MangoPay\Types\Money();
$PayIn->DebitedFunds->Currency = "EUR";
$PayIn->DebitedFunds->Amount = 950;
$PayIn->Fees = new \MangoPay\Types\Money();
$PayIn->Fees->Currency = "EUR";
$PayIn->Fees->Amount = 550;
$PayIn->ExecutionType = "DIRECT";
$PayIn->ExecutionDetails = new \MangoPay\Types\PayInExecutionDetailsDirect();
$result = $mangoPayApi->PayIns->Create($PayIn);

//Display result
pre_dump($result);
$_SESSION["MangoPayDemo"]["PayInCardPreAuth"] = $result->Id;
