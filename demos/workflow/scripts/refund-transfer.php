<?php
$TransferId = $_SESSION["MangoPayDemo"]["Transfer"];
$Refund = new \MangoPay\Entities\Refund();
$Refund->AuthorId = $_SESSION["MangoPayDemo"]["UserNatural"];
$Refund->DebitedFunds = new \MangoPay\Types\Money();
$Refund->DebitedFunds->Currency = "EUR";
$Refund->DebitedFunds->Amount = 760;//Note that partial Refunds for Transfers are not possible
$Refund->Fees = new \MangoPay\Types\Money();
$Refund->Fees->Currency = "EUR";
$Refund->Fees->Amount = -150;
$result = $mangoPayApi->Transfers->CreateRefund($TransferId, $Refund);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["RefundTransfer"] = $result->Id;
