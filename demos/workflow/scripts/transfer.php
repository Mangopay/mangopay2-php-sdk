<?php
$Transfer = new \MangoPay\Entities\Transfer();
$Transfer->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$Transfer->DebitedFunds = new \MangoPay\Types\Money();
$Transfer->DebitedFunds->Currency = "EUR";
$Transfer->DebitedFunds->Amount = 760;
$Transfer->Fees = new \MangoPay\Types\Money();
$Transfer->Fees->Currency = "EUR";
$Transfer->Fees->Amount = 150;
$Transfer->DebitedWalletID = $_SESSION["MangoPayDemo"]["WalletForNaturalUser"];
$Transfer->CreditedWalletId = $_SESSION["MangoPayDemo"]["WalletForLegalUser"];
$result = $mangoPayApi->Transfers->Create($Transfer);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["Transfer"] = $result->Id;
