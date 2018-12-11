<?php

namespace MangoPay\Tests\Cases;

use MangoPay\AVSResult;
use MangoPay\Libraries\Exception;
use MangoPay\PayInPaymentType;


/**
 * Tests methods for pay-ins
 */
class PayInsTest extends Base
{

    function test_PayIns_Create_CardWeb()
    {
        $payIn = $this->getJohnsPayInCardWeb();

        $this->assertTrue($payIn->Id > 0);
        $this->assertSame(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertSame(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
    }

    function test_PayIns_Get_CardWeb()
    {
        $payIn = $this->getJohnsPayInCardWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertSame($payIn->Id, $getPayIn->Id);
        $this->assertSame($payIn->PaymentType, \MangoPay\PayInPaymentType::Card);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertSame(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertSame(\MangoPay\PayInStatus::Created, $getPayIn->Status);
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }

    function test_PayIns_Create_CardDirect()
    {
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);

        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();

        $this->assertTrue($payIn->Id > 0);
        $this->assertEquals($wallet->Id, $payIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->DebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->CreditedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->Fees);
        $this->assertEquals($user->Id, $payIn->AuthorId);
        $this->assertEquals($wallet->Balance->Amount, $beforeWallet->Balance->Amount + $payIn->CreditedFunds->Amount);
        $this->assertEquals(\MangoPay\PayInStatus::Succeeded, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
    }

    function test_PayIns_Get_CardDirect()
    {
        $payIn = $this->getNewPayInCardDirect();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertSame($payIn->Id, $getPayIn->Id);
        $this->assertSame(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertSame(\MangoPay\PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertNotNull($getPayIn->PaymentDetails->CardId);
        $this->assertEquals(AVSResult::FULL_MATCH, $getPayIn->ExecutionDetails->SecurityInfo->AVSResult);
    }

    function test_PayIns_CreateRefund_CardDirect()
    {
        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getNewRefundForPayIn($payIn);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertTrue($refund->Id > 0);
        $this->assertEquals($refund->DebitedFunds->Amount, $payIn->DebitedFunds->Amount);
        $this->assertEquals($walletBefore->Balance->Amount, $walletAfter->Balance->Amount + $payIn->DebitedFunds->Amount);
        $this->assertEquals('PAYOUT', $refund->Type);
        $this->assertEquals('REFUND', $refund->Nature);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $refund->RefundReason);
    }

    function test_PayIns_PreAuthorizedDirect()
    {
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
        $payIn->ExecutionDetails->Culture = 'FR';

        $createPayIn = $this->_api->PayIns->Create($payIn);

        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::Preauthorized, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPreAuthorized', $createPayIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $createPayIn->ExecutionDetails);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->DebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->CreditedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->Fees);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(\MangoPay\PayInStatus::Succeeded, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
    }

    function test_PayIns_BankWireDirect_Create()
    {
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
        $payIn->ExecutionDetails->Culture = "FR";

        $createPayIn = $this->_api->PayIns->Create($payIn);

        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::BankWire, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBankWire', $createPayIn->PaymentDetails);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->PaymentDetails->DeclaredDebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->PaymentDetails->DeclaredFees);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $createPayIn->ExecutionDetails);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(\MangoPay\PayInStatus::Created, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->WireReference);
        $this->assertInstanceOf('\MangoPay\BankAccount', $createPayIn->PaymentDetails->BankAccount);
        $this->assertEquals('IBAN', $createPayIn->PaymentDetails->BankAccount->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->IBAN);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->BIC);
    }

    function test_PayIns_BankWireDirect_Get()
    {
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

        $this->assertEquals($getPayIn->Id, $createdPayIn->Id);
        $this->assertEquals(\MangoPay\PayInPaymentType::BankWire, $getPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBankWire', $getPayIn->PaymentDetails);
        $this->assertInstanceOf('\MangoPay\Money', $getPayIn->PaymentDetails->DeclaredDebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $getPayIn->PaymentDetails->DeclaredFees);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $getPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $getPayIn->ExecutionDetails);
        $this->assertEquals($user->Id, $getPayIn->AuthorId);
        $this->assertEquals('PAYIN', $getPayIn->Type);
        $this->assertNotNull($getPayIn->PaymentDetails->WireReference);
        $this->assertInstanceOf('\MangoPay\BankAccount', $getPayIn->PaymentDetails->BankAccount);
        $this->assertEquals('IBAN', $getPayIn->PaymentDetails->BankAccount->Type);
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->Details->IBAN);
        $this->assertNotNull($getPayIn->PaymentDetails->BankAccount->Details->BIC);
    }

    function test_PayIns_DirectDeDirectDebitWeb_Create()
    {
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
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::DirectDebit, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsDirectDebit', $createPayIn->PaymentDetails);
        $this->assertEquals('GIROPAY', $createPayIn->PaymentDetails->DirectDebitType);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $createPayIn->ExecutionDetails);
        $this->assertEquals("FR", $createPayIn->ExecutionDetails->Culture);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(\MangoPay\PayInStatus::Created, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->DebitedFunds);
        $this->assertEquals(10000, $createPayIn->DebitedFunds->Amount);
        $this->assertEquals("EUR", $createPayIn->DebitedFunds->Currency);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->CreditedFunds);
        $this->assertEquals(9900, $createPayIn->CreditedFunds->Amount);
        $this->assertEquals("EUR", $createPayIn->CreditedFunds->Currency);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->Fees);
        $this->assertEquals(100, $createPayIn->Fees->Amount);
        $this->assertEquals("EUR", $createPayIn->Fees->Currency);
        $this->assertNotNull($createPayIn->ExecutionDetails->ReturnURL);
        $this->assertNotNull($createPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($createPayIn->ExecutionDetails->TemplateURL);
    }

    function test_PayIns_Create_DirectDebitDirect()
    {
        $johnWallet = $this->getJohnsWalletWithMoney();

        $payIn = $this->getNewPayInDirectDebitDirect();

        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();
        $this->assertTrue($payIn->Id > 0);
        $this->assertEquals($wallet->Id, $payIn->CreditedWalletId);
        $this->assertEquals('DIRECT_DEBIT', $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsDirectDebit', $payIn->PaymentDetails);
        $this->assertEquals('DIRECT', $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->DebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->CreditedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $payIn->Fees);
        $this->assertEquals($user->Id, $payIn->AuthorId);
        $this->assertEquals('FAILED', $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
    }

    function test_PayIns_Create_PaypalWeb()
    {
        $payIn = $this->getJohnsPayInPaypalWeb();

        $this->assertTrue($payIn->Id > 0);
        $this->assertSame('PAYPAL', $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPaypal', $payIn->PaymentDetails);
        $this->assertSame('WEB', $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
    }

    function test_PayIns_Get_PaypalWeb()
    {
        $payIn = $this->getJohnsPayInPaypalWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertSame($payIn->Id, $getPayIn->Id);
        $this->assertSame('PAYPAL', $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPaypal', $payIn->PaymentDetails);
        $this->assertSame('WEB', $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertSame('CREATED', $getPayIn->Status);
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }

    function test_PayPal_BuyerAccountEmail()
    {
        $payInId = "54088959";
        $buyerEmail = "paypal-buyer-user@mangopay.com";
        $payin = $this->_api->PayIns->Get($payInId);

        $this->assertNotNull($payin, "PayPal payin came back null");
        $this->assertSame(PayInPaymentType::PayPal, $payin->PaymentType, "Payment is not of PayPal type");

        $paymentDetails = $payin->PaymentDetails;
        $this->assertNotNull($paymentDetails, "Payment details are null");
        $this->assertInstanceOf("\MangoPay\PayInPaymentDetailsPaypal", $paymentDetails);
        $this->assertNotNull($paymentDetails->PaypalBuyerAccountEmail);
        $this->assertSame($paymentDetails->PaypalBuyerAccountEmail, $buyerEmail);
    }

    function test_PayIns_Get_ExtendedCardView()
    {
        $payIn = $this->getJohnsPayInCardWeb();

        $message = null;
        try {
            $this->_api->PayIns->GetExtendedCardView($payIn->Id);
        } catch (Exception $e) {
            // This test will throw \MangoPay\Libraries\ResponseException because some external actions are needed
            // in order to get the PayIn in the CREATED status needed in order to get an extended view for it.
            $message = $e->getMessage();
        }

        $this->assertNotNull($message);
        $this->assertTrue(strpos($message, 'Not found') !== false);
    }

    function test_PayIn_GetRefunds()
    {
        $payIn = $this->getJohnsPayInCardWeb();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->PayIns->GetRefunds($payIn->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertInternalType('array', $refunds);
    }

    function test_PayIns_Culture_Code()
    {
        $payin = $this->getNewPayInCardDirect();

        $this->assertNotNull($payin);
        $this->assertNotNull($payin->ExecutionDetails);
        $this->assertNotNull($payin->ExecutionDetails->Culture);
    }
}

