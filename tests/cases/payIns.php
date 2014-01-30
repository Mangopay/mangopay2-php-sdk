<?php

namespace MangoPay\Tests;

require_once 'base.php';

/**
 * Tests methods for pay-ins
 */
class PayIns extends Base {

    function test_PayIns_Create_CardWeb() {
        $payIn = $this->getJohnsPayInCardWeb();

        $this->assertTrue($payIn->Id > 0);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
    }

    function test_PayIns_Get_CardWeb() {
        $payIn = $this->getJohnsPayInCardWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertIdentical($getPayIn->Status, 'CREATED');
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }

    function test_PayIns_Create_CardDirect() {
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);

        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();

        $this->assertTrue($payIn->Id > 0);
        $this->assertEqual($wallet->Id, $payIn->CreditedWalletId);
        $this->assertEqual('CARD', $payIn->PaymentType);
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertEqual('DIRECT', $payIn->ExecutionType);
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertIsA($payIn->DebitedFunds, '\MangoPay\Money');
        $this->assertIsA($payIn->CreditedFunds, '\MangoPay\Money');
        $this->assertIsA($payIn->Fees, '\MangoPay\Money');
        $this->assertEqual($user->Id, $payIn->AuthorId);
        $this->assertEqual($wallet->Balance->Amount, $beforeWallet->Balance->Amount + $payIn->CreditedFunds->Amount);
        $this->assertEqual('SUCCEEDED', $payIn->Status);
        $this->assertEqual('PAYIN', $payIn->Type);
    }

    function test_PayIns_Get_CardDirect() {
        $payIn = $this->getNewPayInCardDirect();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, 'DIRECT');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertNotNull($getPayIn->PaymentDetails->CardId);
    }

    function test_PayIns_CreateRefund_CardDirect() {
        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getNewRefundForPayIn($payIn);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertTrue($refund->Id > 0);
        $this->assertTrue($refund->DebitedFunds->Amount, $payIn->DebitedFunds->Amount);
        $this->assertEqual($walletBefore->Balance->Amount, $walletAfter->Balance->Amount + $payIn->DebitedFunds->Amount);
        $this->assertEqual('PAYOUT', $refund->Type);
        $this->assertEqual('REFUND', $refund->Nature);
    }
    
    function test_PayIns_PreAuthorizedDirect() {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        // create pay-in PRE-AUTHORIZED DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
        $payIn->PaymentDetails->PreauthorizationId = $cardPreAuthorization->Id;
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        
        $createPayIn = $this->_api->PayIns->Create($payIn);
        
        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEqual($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEqual('PREAUTHORIZED', $createPayIn->PaymentType);
        $this->assertIsA($createPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsPreAuthorized');
        $this->assertEqual('DIRECT', $createPayIn->ExecutionType);
        $this->assertIsA($createPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertIsA($createPayIn->DebitedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->CreditedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->Fees, '\MangoPay\Money');
        $this->assertEqual($user->Id, $createPayIn->AuthorId);
        $this->assertEqual('SUCCEEDED', $createPayIn->Status);
        $this->assertEqual('PAYIN', $createPayIn->Type);
    }
    
    function test_PayIns_BankWireDirect_Create() {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create pay-in PRE-AUTHORIZED DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 10000;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->PaymentDetails->DeclaredFees = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredFees->Amount = 0;
        $payIn->PaymentDetails->DeclaredFees->Currency = 'EUR';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        
        $createPayIn = $this->_api->PayIns->Create($payIn);
        
        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEqual($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEqual('BANK_WIRE', $createPayIn->PaymentType);
        $this->assertIsA($createPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsBankWire');
        $this->assertIsA($createPayIn->PaymentDetails->DeclaredDebitedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->PaymentDetails->DeclaredFees, '\MangoPay\Money');
        $this->assertEqual('DIRECT', $createPayIn->ExecutionType);
        $this->assertIsA($createPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertEqual($user->Id, $createPayIn->AuthorId);
        $this->assertEqual('CREATED', $createPayIn->Status);
        $this->assertEqual('PAYIN', $createPayIn->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->WireReference);
        $this->assertIsA($createPayIn->PaymentDetails->BankAccount, '\MangoPay\BankAccount');
        $this->assertEqual($createPayIn->PaymentDetails->BankAccount->Type, 'IBAN');
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->IBAN);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->BIC);
    }
    
    function test_PayIns_BankWireDirect_Get() {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create pay-in PRE-AUTHORIZED DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 10000;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->PaymentDetails->DeclaredFees = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredFees->Amount = 0;
        $payIn->PaymentDetails->DeclaredFees->Currency = 'EUR';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $createdPayIn = $this->_api->PayIns->Create($payIn);

        $getPayIn = $this->_api->PayIns->Get($createdPayIn->Id);
        
        $this->assertEqual($getPayIn->Id, $createdPayIn->Id);
        $this->assertEqual('BANK_WIRE', $getPayIn->PaymentType);
        $this->assertIsA($getPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsBankWire');
        $this->assertIsA($getPayIn->PaymentDetails->DeclaredDebitedFunds, '\MangoPay\Money');
        $this->assertIsA($getPayIn->PaymentDetails->DeclaredFees, '\MangoPay\Money');
        $this->assertEqual('DIRECT', $getPayIn->ExecutionType);
        $this->assertIsA($getPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertEqual($user->Id, $getPayIn->AuthorId);
        $this->assertEqual('PAYIN', $getPayIn->Type);
        $this->assertNotNull($getPayIn->PaymentDetails->WireReference);
        $this->assertIsA($getPayIn->PaymentDetails->BankAccount, '\MangoPay\BankAccount');
        $this->assertEqual($getPayIn->PaymentDetails->BankAccount->Type, 'IBAN');
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->IBAN);
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->BIC);
        
        
        
        
    }
}

