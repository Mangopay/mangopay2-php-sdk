<?php
$UserId = $_SESSION["MangoPayDemo"]["UserLegal"];
$BankAccount = new \MangoPay\Entities\BankAccount();
$BankAccount->Type = "IBAN";
$BankAccount->Details = new MangoPay\Types\BankAccountDetailsIBAN();
$BankAccount->Details->IBAN = "FR3020041010124530725S03383";
$BankAccount->Details->BIC = "CRLYFRPP";
$BankAccount->OwnerName = "Joe Bloggs";
$BankAccount->OwnerAddress = "1 Mangopay Street";
$result = $mangoPayApi->Users->CreateBankAccount($UserId, $BankAccount);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["BankAccount"] = $result->Id;
