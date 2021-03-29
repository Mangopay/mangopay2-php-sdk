<?php
$UserId = $_SESSION["MangoPayDemo"]["UserLegal"];
$BankAccount = new \MangoPay\BankAccount();
$BankAccount->Type = "IBAN";
$BankAccount->Details = new MangoPay\BankAccountDetailsIBAN();
$BankAccount->Details->IBAN = "FR7630004000031234567890143";
$BankAccount->Details->BIC = "CRLYFRPP";
$BankAccount->OwnerName = "Joe Bloggs";
$BankAccount->OwnerAddress = new \MangoPay\Address();
$BankAccount->OwnerAddress->AddressLine1 = 'Address line 1';
$BankAccount->OwnerAddress->AddressLine2 = 'Address line 2';
$BankAccount->OwnerAddress->City = 'City';
$BankAccount->OwnerAddress->Country = 'FR';
$BankAccount->OwnerAddress->PostalCode = '11222';
$BankAccount->OwnerAddress->Region = 'Region';
$result = $mangoPayApi->Users->CreateBankAccount($UserId, $BankAccount);

//Display result
pre_dump($result);

$_SESSION["MangoPayDemo"]["BankAccount"] = $result->Id;
