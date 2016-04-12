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
        $this->assertIdentical($payIn->PaymentType, \MangoPay\PayInPaymentType::Card);
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, \MangoPay\PayInExecutionType::Web);
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
    }

    function test_PayIns_Get_CardWeb() {
        $payIn = $this->getJohnsPayInCardWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, \MangoPay\PayInPaymentType::Card);
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, \MangoPay\PayInExecutionType::Web);
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertIdentical($getPayIn->Status, \MangoPay\PayInStatus::Created);
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
        $this->assertEqual(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertEqual(\MangoPay\PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertIsA($payIn->DebitedFunds, '\MangoPay\Money');
        $this->assertIsA($payIn->CreditedFunds, '\MangoPay\Money');
        $this->assertIsA($payIn->Fees, '\MangoPay\Money');
        $this->assertEqual($user->Id, $payIn->AuthorId);
        $this->assertEqual($wallet->Balance->Amount, $beforeWallet->Balance->Amount + $payIn->CreditedFunds->Amount);
        $this->assertEqual(\MangoPay\PayInStatus::Succeeded, $payIn->Status);
        $this->assertEqual('PAYIN', $payIn->Type);
    }

    function test_PayIns_Get_CardDirect() {
        $payIn = $this->getNewPayInCardDirect();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, \MangoPay\PayInPaymentType::Card);
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, \MangoPay\PayInExecutionType::Direct);
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
        $this->assertIsA($refund->RefundReason, '\MangoPay\RefundReasonDetails');
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
        $this->assertEqual(\MangoPay\PayInPaymentType::Preauthorized, $createPayIn->PaymentType);
        $this->assertIsA($createPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsPreAuthorized');
        $this->assertEqual(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertIsA($createPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertIsA($createPayIn->DebitedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->CreditedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->Fees, '\MangoPay\Money');
        $this->assertEqual($user->Id, $createPayIn->AuthorId);
        $this->assertEqual(\MangoPay\PayInStatus::Succeeded, $createPayIn->Status);
        $this->assertEqual('PAYIN', $createPayIn->Type);
    }
    
    function test_PayIns_BankWireDirect_Create() {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create pay-in BANKWIRE DIRECT
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
        $this->assertEqual(\MangoPay\PayInPaymentType::BankWire, $createPayIn->PaymentType);
        $this->assertIsA($createPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsBankWire');
        $this->assertIsA($createPayIn->PaymentDetails->DeclaredDebitedFunds, '\MangoPay\Money');
        $this->assertIsA($createPayIn->PaymentDetails->DeclaredFees, '\MangoPay\Money');
        $this->assertEqual(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertIsA($createPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertEqual($user->Id, $createPayIn->AuthorId);
        $this->assertEqual(\MangoPay\PayInStatus::Created, $createPayIn->Status);
        $this->assertEqual('PAYIN', $createPayIn->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->WireReference);
        $this->assertIsA($createPayIn->PaymentDetails->BankAccount, '\MangoPay\BankAccount');
        $this->assertEqual($createPayIn->PaymentDetails->BankAccount->Type, 'IBAN');
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->IBAN);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->BIC);
    }
    
    function test_PayIns_BankWireDirect_Get() {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create pay-in BANKWIRE DIRECT
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
        $this->assertEqual(\MangoPay\PayInPaymentType::BankWire, $getPayIn->PaymentType);
        $this->assertIsA($getPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsBankWire');
        $this->assertIsA($getPayIn->PaymentDetails->DeclaredDebitedFunds, '\MangoPay\Money');
        $this->assertIsA($getPayIn->PaymentDetails->DeclaredFees, '\MangoPay\Money');
        $this->assertEqual(\MangoPay\PayInExecutionType::Direct, $getPayIn->ExecutionType);
        $this->assertIsA($getPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
        $this->assertEqual($user->Id, $getPayIn->AuthorId);
        $this->assertEqual('PAYIN', $getPayIn->Type);
        $this->assertNotNull($getPayIn->PaymentDetails->WireReference);
        $this->assertIsA($getPayIn->PaymentDetails->BankAccount, '\MangoPay\BankAccount');
        $this->assertEqual($getPayIn->PaymentDetails->BankAccount->Type, 'IBAN');
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->Details->IBAN);
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->Details->BIC);
    }
    
    function test_PayIns_DirectDebitWeb_Create() {
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create pay-in DIRECT DEBIT WEB
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 100;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->DirectDebitType = "GIROPAY";
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.mysite.com/returnURL/";
        $payIn->ExecutionDetails->Culture = "FR";
        $payIn->ExecutionDetails->TemplateURLOptions = new \MangoPay\PayInTemplateURLOptions();
        $payIn->ExecutionDetails->TemplateURLOptions->PAYLINE = "https://www.maysite.com/payline_template/";                

        $createPayIn = $this->_api->PayIns->Create($payIn);

        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEqual($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEqual(\MangoPay\PayInPaymentType::DirectDebit, $createPayIn->PaymentType);
        $this->assertIsA($createPayIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsDirectDebit');
        $this->assertEqual($createPayIn->PaymentDetails->DirectDebitType, 'GIROPAY');
        $this->assertEqual(\MangoPay\PayInExecutionType::Web, $createPayIn->ExecutionType);
        $this->assertIsA($createPayIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
        $this->assertEqual("FR", $createPayIn->ExecutionDetails->Culture);
        $this->assertEqual($user->Id, $createPayIn->AuthorId);
        $this->assertEqual(\MangoPay\PayInStatus::Created, $createPayIn->Status);
        $this->assertEqual('PAYIN', $createPayIn->Type);
        $this->assertIsA($createPayIn->DebitedFunds, '\MangoPay\Money');
        $this->assertEqual(10000, $createPayIn->DebitedFunds->Amount);
        $this->assertEqual("EUR", $createPayIn->DebitedFunds->Currency);
        $this->assertIsA($createPayIn->CreditedFunds, '\MangoPay\Money');
        $this->assertEqual(9900, $createPayIn->CreditedFunds->Amount);
        $this->assertEqual("EUR", $createPayIn->CreditedFunds->Currency);
        $this->assertIsA($createPayIn->Fees, '\MangoPay\Money');
        $this->assertEqual(100, $createPayIn->Fees->Amount);
        $this->assertEqual("EUR", $createPayIn->Fees->Currency);
        $this->assertNotNull($createPayIn->ExecutionDetails->ReturnURL);
        $this->assertNotNull($createPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($createPayIn->ExecutionDetails->TemplateURL);
    }

    function test_PayIns_Create_DirectDebitDirect() {
         $johnWallet = $this->getJohnsWalletWithMoney();
         
         $payIn = $this->getNewPayInDirectDebitDirect();
 
         $wallet = $this->_api->Wallets->Get($johnWallet->Id);
         $user = $this->getJohn();
         $this->assertTrue($payIn->Id > 0);
         $this->assertEqual($wallet->Id, $payIn->CreditedWalletId);
         $this->assertEqual('DIRECT_DEBIT', $payIn->PaymentType);
         $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsDirectDebit');
         $this->assertEqual('DIRECT', $payIn->ExecutionType);
         $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsDirect');
         $this->assertIsA($payIn->DebitedFunds, '\MangoPay\Money');
         $this->assertIsA($payIn->CreditedFunds, '\MangoPay\Money');
         $this->assertIsA($payIn->Fees, '\MangoPay\Money');
         $this->assertEqual($user->Id, $payIn->AuthorId);
         $this->assertEqual('FAILED', $payIn->Status);
         $this->assertEqual('PAYIN', $payIn->Type);
     }

	 function test_PayIns_Create_PaypalWeb() {
        $payIn = $this->getJohnsPayInPaypalWeb();

        $this->assertTrue($payIn->Id > 0);
        $this->assertIdentical($payIn->PaymentType, 'PAYPAL');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsPaypal');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
    }
    
    function test_PayIns_Get_PaypalWeb() {
        $payIn = $this->getJohnsPayInPaypalWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, 'PAYPAL');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsPaypal');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertIdentical($getPayIn->Status, 'CREATED');
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }
}

