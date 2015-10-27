<?php
$UserId = $_SESSION["MangoPayDemo"]["UserLegal"];
$BankAccount = new \MangoPay\BankAccount();
$BankAccount->Type = "IBAN";
$BankAccount->Details = new MangoPay\BankAccountDetailsIBAN();
$BankAccount->Details->IBAN = "FR7618829754160173622224154";
$BankAccount->Details->BIC = "CMBRFR2BCME";
$BankAccount->OwnerName = "Joe Bloggs";
$BankAccount->OwnerAddress = "1 Mangopay Street";
$result = $mangoPayApi->Users->CreateBankAccount($UserId, $BankAccount);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["BankAccount"] = $result->Id;
