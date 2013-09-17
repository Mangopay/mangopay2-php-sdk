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
        $this->assertNotNull($getPayIn->ExecutionDetails->CardId);
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

}

