<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CreateCardPreAuthorizedDepositPayIn;
use MangoPay\Libraries\Exception;
use MangoPay\LineItem;
use MangoPay\Money;
use MangoPay\PayInExecutionType;
use MangoPay\PayInPaymentDetailsBankWire;
use MangoPay\PayInPaymentType;
use MangoPay\PayInRecurringRegistrationUpdate;
use MangoPay\PayInStatus;
use MangoPay\RecurringPayInCIT;
use MangoPay\RecurringPayPalPayInCIT;
use MangoPay\RecurringPayPalPayInMIT;
use MangoPay\TransactionStatus;
use MangoPay\UpdateDeposit;

/**
 * Tests methods for pay-ins
 */
class PayInsTest extends Base
{
    public static $RecurringPayPalPayInRegistration;

    public function test_PayIns_Create_CardWeb()
    {
        $payIn = $this->getJohnsPayInCardWeb();

        $this->assertNotNull($payIn->Id);
        $this->assertSame(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertSame(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertNotNull($payIn->ExecutionDetails->Billing);
    }

    public function test_PayIns_Get_CardWeb()
    {
        $payIn = $this->getJohnsPayInCardWeb();

        $getPayIn = $this->_api->PayIns->Get($payIn->Id);

        $this->assertSame($payIn->Id, $getPayIn->Id);
        $this->assertSame($payIn->PaymentType, \MangoPay\PayInPaymentType::Card);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertSame(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertSame(PayInStatus::Created, $getPayIn->Status);
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }

    public function test_PayIns_Create_CardDirect()
    {
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);

        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();

        $this->assertNotNull($payIn->Id);
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
        $this->assertEquals(PayInStatus::Succeeded, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('TelephoneOrder', $payIn->PaymentCategory);

        $this->assertNotNull($payIn->PaymentDetails->CardInfo);
//        $this->assertNotNull($payIn->PaymentDetails->CardInfo->BIN);
//        $this->assertNotNull($payIn->PaymentDetails->CardInfo->Type);
    }

    public function test_PayIns_Get_CardDirect()
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
        //FIX ME - To be uncommented when AVS provided will answer properly again.
        //$this->assertEquals(AVSResult::NO_CHECK, $getPayIn->ExecutionDetails->SecurityInfo->AVSResult);
    }

    public function test_PayIns_CreateRefund_CardDirect()
    {
        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getNewRefundForPayIn($payIn);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertNotNull($refund->Id);
        $this->assertEquals($refund->DebitedFunds->Amount, $payIn->DebitedFunds->Amount);
        $this->assertEquals($walletBefore->Balance->Amount, $walletAfter->Balance->Amount + $payIn->DebitedFunds->Amount);
        $this->assertEquals('PAYOUT', $refund->Type);
        $this->assertEquals('REFUND', $refund->Nature);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $refund->RefundReason);
    }

    public function test_PayIns_CreatePartialRefund_CardDirect()
    {
        $payIn = $this->getNewPayInCardDirect();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getPartialRefundForPayIn($payIn);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertNotNull($refund->Id);
        $this->assertEquals($walletAfter->Balance->Amount, $walletBefore->Balance->Amount - $refund->DebitedFunds->Amount);
        $this->assertEquals('PAYOUT', $refund->Type);
        $this->assertEquals('REFUND', $refund->Nature);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $refund->RefundReason);
    }

    public function test_PayIns_PreAuthorizedDirect()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        // create pay-in PRE-AUTHORIZED DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 1000;
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
        sleep(2);
        $transactions = $this->_api->CardPreAuthorizations->GetTransactions($cardPreAuthorization->Id);

        $this->assertNotNull($createPayIn->Id);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::Preauthorized, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPreAuthorized', $createPayIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $createPayIn->ExecutionDetails);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->DebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->CreditedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->Fees);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(PayInStatus::Succeeded, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
        $this->assertEquals($transactions[0]->Status, TransactionStatus::Succeeded);
    }

    public function test_PayIns_BankWireDirect_Create()
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

        $this->assertNotNull($createPayIn->Id);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::BankWire, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBankWire', $createPayIn->PaymentDetails);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->PaymentDetails->DeclaredDebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->PaymentDetails->DeclaredFees);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $createPayIn->ExecutionDetails);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(PayInStatus::Created, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->WireReference);
        $this->assertInstanceOf('\MangoPay\BankAccount', $createPayIn->PaymentDetails->BankAccount);
        $this->assertEquals('IBAN', $createPayIn->PaymentDetails->BankAccount->Type);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->IBAN);
        $this->assertNotNull($createPayIn->PaymentDetails->BankAccount->Details->BIC);
    }

    public function test_PayIns_BankWireDirect_Get()
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

    public function test_PayIns_DirectDeDirectDebitWeb_Create()
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
        $payIn->ExecutionDetails->TemplateURL = "https://www.maysite.com/payline_template/";

        $createPayIn = $this->_api->PayIns->Create($payIn);

        $this->assertNotNull($createPayIn->Id);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals(\MangoPay\PayInPaymentType::DirectDebit, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsDirectDebit', $createPayIn->PaymentDetails);
        $this->assertEquals('GIROPAY', $createPayIn->PaymentDetails->DirectDebitType);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $createPayIn->ExecutionDetails);
        $this->assertEquals("FR", $createPayIn->ExecutionDetails->Culture);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(PayInStatus::Created, $createPayIn->Status);
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
    }

    public function test_PayIns_Create_DirectDebitDirect()
    {
        $johnWallet = $this->getJohnsWalletWithMoney();

        $payIn = $this->getNewPayInDirectDebitDirect();

        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();
        $this->assertNotNull($payIn->Id);
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

    public function test_PayIns_Create_PaypalWeb()
    {
        $payIn = $this->getJohnsPayInPaypalWeb();

        $this->assertNotNull($payIn->Id);
        $this->assertSame('PAYPAL', $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPaypal', $payIn->PaymentDetails);
        $this->assertSame('WEB', $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertSame('FR', $payIn->ExecutionDetails->Culture);
    }

    public function test_PayIns_Create_PaypalWebV2()
    {
        $payIn = $this->getJohnsPayInPaypalWebV2();

        $this->assertNotNull($payIn->Id);
        $this->assertSame('CREATED', $payIn->Status);
        $this->assertSame('PAYPAL', $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPaypal', $payIn->PaymentDetails);
        $this->assertSame('WEB', $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertNotNull($payIn->PaymentDetails->StatementDescriptor);
        $this->assertNotNull($payIn->PaymentDetails->LineItems);
        $this->assertNotNull($payIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($payIn->ExecutionDetails->ReturnURL);

        $fetched = $this->_api->PayIns->Get($payIn->Id);
        $this->assertSame($fetched->Id, $payIn->Id);
    }

    public function test_PayIns_Create_PayconiqWeb()
    {
        $payIn = $this->getJohnsPayInPayconiqWeb();

        $this->assertNotNull($payIn->Id);
    }

    public function test_PayIns_Create_PayconiqWebV2()
    {
        $payIn = $this->getJohnsPayInPayconiqWebV2();
        $this->assertNotNull($payIn->Id);
        $this->assertNotNull($payIn->PaymentDetails->QRCodeURL);
        $this->assertNotNull($payIn->PaymentDetails->DeepLinkURL);
    }

    public function test_PayIns_Get_PaypalWeb()
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
        $this->assertSame('FR', $getPayIn->ExecutionDetails->Culture);
    }

    public function test_PayPal_BuyerAccountEmail()
    {
        $this->markTestSkipped("Expired payin id");
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

    public function test_PayIns_Get_ExtendedCardView()
    {
        $this->markTestSkipped("api returns 404");
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

    public function test_PayIn_GetRefunds()
    {
        $payIn = $this->getJohnsPayInCardWeb();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->PayIns->GetRefunds($payIn->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertTrue(is_array($refunds), 'Expected an array');
    }

    public function test_PayIns_Culture_Code()
    {
        $payin = $this->getNewPayInCardDirect();

        $this->assertNotNull($payin);
        $this->assertNotNull($payin->ExecutionDetails);
        $this->assertNotNull($payin->ExecutionDetails->Culture);
    }

    public function test_get_bank_wire_external_instructions_iban()
    {
        $payIn = $this->_api->PayIns->Get("payin_m_01JK6199ED4VGBP98ABRJVDS9D");

        $this->assertTrue($payIn->PaymentType == PayInPaymentType::BankWire);
        $this->assertTrue($payIn->PaymentDetails instanceof PayInPaymentDetailsBankWire);
        $this->assertTrue($payIn->ExecutionType == PayInExecutionType::ExternalInstruction);

        $this->assertTrue($payIn->Status == TransactionStatus::Succeeded);
        $this->assertTrue($payIn->ExecutionDate != null);
        $this->assertNotNull($payIn->ExecutionDetails->DebitedBankAccount->IBAN);
        $this->assertNull($payIn->ExecutionDetails->DebitedBankAccount->AccountNumber);
    }

    public function test_get_bank_wire_external_instructions_account_number()
    {
        $this->markTestSkipped("Expired payin id");
        $payIn = $this->_api->PayIns->Get("74981216");

        $this->assertTrue($payIn->PaymentType == PayInPaymentType::BankWire);
        $this->assertTrue($payIn->PaymentDetails instanceof PayInPaymentDetailsBankWire);
        $this->assertTrue($payIn->ExecutionType == PayInExecutionType::ExternalInstruction);

        $this->assertTrue($payIn->Status == TransactionStatus::Succeeded);
        $this->assertTrue($payIn->ExecutionDate != null);
        $this->assertNull($payIn->ExecutionDetails->DebitedBankAccount->IBAN);
        $this->assertNotNull($payIn->ExecutionDetails->DebitedBankAccount->AccountNumber);
    }

    public function test_PayIns_Apple_Pay_Create()
    {
        $this->markTestSkipped('Problems with Apple Pay');
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        // create Apple Pay direct pay-in
        $applePayPayIn = new \MangoPay\PayIn();
        $applePayPayIn->CreditedWalletId = $wallet->Id;
        $applePayPayIn->AuthorId = $user->Id;
        $applePayPayIn->CreditedUserId = $user->Id;
        $applePayPayIn->DebitedFunds = new \MangoPay\Money();
        $applePayPayIn->DebitedFunds->Amount = 199;
        $applePayPayIn->DebitedFunds->Currency = 'EUR';
        $applePayPayIn->Fees = new \MangoPay\Money();
        $applePayPayIn->Fees->Amount = 1;
        $applePayPayIn->Fees->Currency = 'EUR';
        $applePayPayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        // payment data
        $applePayPayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsApplePay();
        $applePayPayIn->PaymentDetails->PaymentData = new \MangoPay\PaymentData();
        $applePayPayIn->PaymentDetails->PaymentData->TransactionId = '061EB32181A2D9CA42AD16031B476EEBAA62A9A095AD660E2759FBA52B51A61';
        $applePayPayIn->PaymentDetails->PaymentData->Network = 'VISA';
        $applePayPayIn->PaymentDetails->PaymentData->TokenData = "{\"version\":\"EC_v1\",\"data\":\"w4HMBVqNC9ghPP4zncTA\/0oQAsduERfsx78oxgniynNjZLANTL6+0koEtkQnW\/K38Zew8qV1GLp+fLHo+qCBpiKCIwlz3eoFBTbZU+8pYcjaeIYBX9SOxcwxXsNGrGLk+kBUqnpiSIPaAG1E+WPT8R1kjOCnGvtdombvricwRTQkGjtovPfzZo8LzD3ZQJnHMsWJ8QYDLyr\/ZN9gtLAtsBAMvwManwiaG3pOIWpyeOQOb01YcEVO16EZBjaY4x4C\/oyFLWDuKGvhbJwZqWh1d1o9JT29QVmvy3Oq2JEjq3c3NutYut4rwDEP4owqI40Nb7mP2ebmdNgnYyWfPmkRfDCRHIWtbMC35IPg5313B1dgXZ2BmyZRXD5p+mr67vAk7iFfjEpu3GieFqwZrTl3\/pI5V8Sxe3SIYKgT5Hr7ow==\",\"signature\":\"MIAGCSqGSIb3DQEHAqCAMIACAQExDzANBglghkgBZQMEAgEFADCABgkqhkiG9w0BBwEAAKCAMIID5jCCA4ugAwIBAgIIaGD2mdnMpw8wCgYIKoZIzj0EAwIwejEuMCwGA1UEAwwlQXBwbGUgQXBwbGljYXRpb24gSW50ZWdyYXRpb24gQ0EgLSBHMzEmMCQGA1UECwwdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTMB4XDTE2MDYwMzE4MTY0MFoXDTIxMDYwMjE4MTY0MFowYjEoMCYGA1UEAwwfZWNjLXNtcC1icm9rZXItc2lnbl9VQzQtU0FOREJPWDEUMBIGA1UECwwLaU9TIFN5c3RlbXMxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTMFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEgjD9q8Oc914gLFDZm0US5jfiqQHdbLPgsc1LUmeY+M9OvegaJajCHkwz3c6OKpbC9q+hkwNFxOh6RCbOlRsSlaOCAhEwggINMEUGCCsGAQUFBwEBBDkwNzA1BggrBgEFBQcwAYYpaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwNC1hcHBsZWFpY2EzMDIwHQYDVR0OBBYEFAIkMAua7u1GMZekplopnkJxghxFMAwGA1UdEwEB\/wQCMAAwHwYDVR0jBBgwFoAUI\/JJxE+T5O8n5sT2KGw\/orv9LkswggEdBgNVHSAEggEUMIIBEDCCAQwGCSqGSIb3Y2QFATCB\/jCBwwYIKwYBBQUHAgIwgbYMgbNSZWxpYW5jZSBvbiB0aGlzIGNlcnRpZmljYXRlIGJ5IGFueSBwYXJ0eSBhc3N1bWVzIGFjY2VwdGFuY2Ugb2YgdGhlIHRoZW4gYXBwbGljYWJsZSBzdGFuZGFyZCB0ZXJtcyBhbmQgY29uZGl0aW9ucyBvZiB1c2UsIGNlcnRpZmljYXRlIHBvbGljeSBhbmQgY2VydGlmaWNhdGlvbiBwcmFjdGljZSBzdGF0ZW1lbnRzLjA2BggrBgEFBQcCARYqaHR0cDovL3d3dy5hcHBsZS5jb20vY2VydGlmaWNhdGVhdXRob3JpdHkvMDQGA1UdHwQtMCswKaAnoCWGI2h0dHA6Ly9jcmwuYXBwbGUuY29tL2FwcGxlYWljYTMuY3JsMA4GA1UdDwEB\/wQEAwIHgDAPBgkqhkiG92NkBh0EAgUAMAoGCCqGSM49BAMCA0kAMEYCIQDaHGOui+X2T44R6GVpN7m2nEcr6T6sMjOhZ5NuSo1egwIhAL1a+\/hp88DKJ0sv3eT3FxWcs71xmbLKD\/QJ3mWagrJNMIIC7jCCAnWgAwIBAgIISW0vvzqY2pcwCgYIKoZIzj0EAwIwZzEbMBkGA1UEAwwSQXBwbGUgUm9vdCBDQSAtIEczMSYwJAYDVQQLDB1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTETMBEGA1UECgwKQXBwbGUgSW5jLjELMAkGA1UEBhMCVVMwHhcNMTQwNTA2MjM0NjMwWhcNMjkwNTA2MjM0NjMwWjB6MS4wLAYDVQQDDCVBcHBsZSBBcHBsaWNhdGlvbiBJbnRlZ3JhdGlvbiBDQSAtIEczMSYwJAYDVQQLDB1BcHBsZSBDZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTETMBEGA1UECgwKQXBwbGUgSW5jLjELMAkGA1UEBhMCVVMwWTATBgcqhkjOPQIBBggqhkjOPQMBBwNCAATwFxGEGddkhdUaXiWBB3bogKLv3nuuTeCN\/EuT4TNW1WZbNa4i0Jd2DSJOe7oI\/XYXzojLdrtmcL7I6CmE\/1RFo4H3MIH0MEYGCCsGAQUFBwEBBDowODA2BggrBgEFBQcwAYYqaHR0cDovL29jc3AuYXBwbGUuY29tL29jc3AwNC1hcHBsZXJvb3RjYWczMB0GA1UdDgQWBBQj8knET5Pk7yfmxPYobD+iu\/0uSzAPBgNVHRMBAf8EBTADAQH\/MB8GA1UdIwQYMBaAFLuw3qFYM4iapIqZ3r6966\/ayySrMDcGA1UdHwQwMC4wLKAqoCiGJmh0dHA6Ly9jcmwuYXBwbGUuY29tL2FwcGxlcm9vdGNhZzMuY3JsMA4GA1UdDwEB\/wQEAwIBBjAQBgoqhkiG92NkBgIOBAIFADAKBggqhkjOPQQDAgNnADBkAjA6z3KDURaZsYb7NcNWymK\/9Bft2Q91TaKOvvGcgV5Ct4n4mPebWZ+Y1UENj53pwv4CMDIt1UQhsKMFd2xd8zg7kGf9F3wsIW2WT8ZyaYISb1T4en0bmcubCYkhYQaZDwmSHQAAMYIBizCCAYcCAQEwgYYwejEuMCwGA1UEAwwlQXBwbGUgQXBwbGljYXRpb24gSW50ZWdyYXRpb24gQ0EgLSBHMzEmMCQGA1UECwwdQXBwbGUgQ2VydGlmaWNhdGlvbiBBdXRob3JpdHkxEzARBgNVBAoMCkFwcGxlIEluYy4xCzAJBgNVBAYTAlVTAghoYPaZ2cynDzANBglghkgBZQMEAgEFAKCBlTAYBgkqhkiG9w0BCQMxCwYJKoZIhvcNAQcBMBwGCSqGSIb3DQEJBTEPFw0xOTA1MjMxMTA1MDdaMCoGCSqGSIb3DQEJNDEdMBswDQYJYIZIAWUDBAIBBQChCgYIKoZIzj0EAwIwLwYJKoZIhvcNAQkEMSIEIIvfGVQYBeOilcB7GNI8m8+FBVZ28QfA6BIXaggBja2PMAoGCCqGSM49BAMCBEYwRAIgU01yYfjlx9bvGeC5CU2RS5KBEG+15HH9tz\/sg3qmQ14CID4F4ZJwAz+tXAUcAIzoMpYSnM8YBlnGJSTSp+LhspenAAAAAAAA\",\"header\":{\"ephemeralPublicKey\":\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE0rs3wRpirXjPbFDQfPRdfEzRIZDWm0qn7Y0HB0PNzV1DDKfpYrnhRb4GEhBF\/oEXBOe452PxbCnN1qAlqcSUWw==\",\"publicKeyHash\":\"saPRAqS7TZ4bAYwzBj8ezDDC55ZolyH1FL+Xc8fd93o=\",\"transactionId\":\"b061eb32181a2d9ca42ad16031b476eebaa62a9a095ad660e2759fba52b51a61\"}}";

        $applePayPayIn->PaymentDetails->StatementDescriptor = 'PHP';
        $applePayPayIn->Tag = 'Create an ApplePay card direct Payin';

        $createPayIn = $this->_api->PayIns->Create($applePayPayIn, null);
        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(PayInStatus::Succeeded, $createPayIn->Status);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->DebitedFunds);
        $this->assertEquals(199, $createPayIn->DebitedFunds->Amount);
        $this->assertEquals("EUR", $createPayIn->DebitedFunds->Currency);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->Fees);
        $this->assertEquals(1, $createPayIn->Fees->Amount);
        $this->assertEquals("EUR", $createPayIn->Fees->Currency);
    }

    private function getRecurringPayin()
    {
        $values = $this->getJohnsWalletWithMoneyAndCardId(1000);
        $walletId = $values["walletId"];
        $cardId = $values["cardId"];
        $user = $this->getJohn();

        $payIn = new \MangoPay\PayInRecurringRegistration();
        $payIn->AuthorId = $user->Id;
        $payIn->CardId = $cardId;
        $payIn->CreditedUserId = $user->Id;
        $payIn->CreditedWalletId = $walletId;
        $payIn->FirstTransactionDebitedFunds = new \MangoPay\Money();
        $payIn->FirstTransactionDebitedFunds->Amount = 12;
        $payIn->FirstTransactionDebitedFunds->Currency = 'EUR';
        $payIn->FirstTransactionFees = new \MangoPay\Money();
        $payIn->FirstTransactionFees->Amount = 1;
        $payIn->FirstTransactionFees->Currency = 'EUR';
        $billing = new \MangoPay\Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $this->getNewAddress();
        $shipping = new \MangoPay\Shipping();
        $shipping->FirstName = 'John';
        $shipping->LastName = 'Doe';
        $shipping->Address = $this->getNewAddress();
        $payIn->Shipping = $shipping;
        $payIn->Billing = $billing;
        $payIn->FreeCycles = 0;

        return $this->_api->PayIns->CreateRecurringRegistration($payIn);
    }

    private function getRecurringPayinRegistrationPaypal()
    {
        if (self::$RecurringPayPalPayInRegistration == null) {
            $values = $this->getJohnsWalletWithMoneyAndCardId();
            $walletId = $values["walletId"];
            $user = $this->getJohn();

            $payIn = new \MangoPay\PayInRecurringRegistration();
            $payIn->AuthorId = $user->Id;
            $payIn->CreditedWalletId = $walletId;
            $payIn->FirstTransactionDebitedFunds = new \MangoPay\Money();
            $payIn->FirstTransactionDebitedFunds->Amount = 100;
            $payIn->FirstTransactionDebitedFunds->Currency = 'EUR';
            $payIn->FirstTransactionFees = new \MangoPay\Money();
            $payIn->FirstTransactionFees->Amount = 0;
            $payIn->FirstTransactionFees->Currency = 'EUR';
            $billing = new \MangoPay\Billing();
            $billing->FirstName = 'John';
            $billing->LastName = 'Doe';
            $billing->Address = $this->getNewAddress();
            $shipping = new \MangoPay\Shipping();
            $shipping->FirstName = 'John';
            $shipping->LastName = 'Doe';
            $shipping->Address = $this->getNewAddress();
            $payIn->Shipping = $shipping;
            $payIn->Billing = $billing;
            $payIn->PaymentType = "PAYPAL";

            self::$RecurringPayPalPayInRegistration = $this->_api->PayIns->CreateRecurringRegistration($payIn);
        }
        return self::$RecurringPayPalPayInRegistration;
    }

    public function test_Create_Recurring_Payment()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $result = $this->getRecurringPayin();

        $this->assertNotNull($result);
        $this->assertNotNull($result->Id);
        $this->assertNotNull($result->FreeCycles);
    }

    public function test_Get_Recurring_Payment()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $result = $this->getRecurringPayin();
        $this->assertNotNull($result);

        $get = $this->_api->PayIns->GetRecurringRegistration($result->Id);
        $this->assertSame($result->Id, $get->Id);
        $this->assertNotNull($get);

        $this->assertNotNull($get->FreeCycles);
    }

    public function test_Update_Recurring_Payment()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $result = $this->getRecurringPayin();
        $this->assertNotNull($result);

        $get = $this->_api->PayIns->GetRecurringRegistration($result->Id);
        $this->assertNotNull($get);

        $update = new PayInRecurringRegistrationUpdate();
        $update->Id = $result->Id;
        $update->Shipping = $result->Shipping;
        $update->Shipping->FirstName = "TEST";
        $update->Billing = $result->Billing;
        $update->Billing->FirstName = "TEST AGAIN";
        $update->Status = "ENDED";

        $updatedResult = $this->_api->PayIns->UpdateRecurringRegistration($update);
        $this->assertNotNull($updatedResult);
    }

    public function test_Create_Recurring_PayIn_CIT()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $registration = $this->getRecurringPayin();

        $cit = new RecurringPayInCIT();
        $cit->RecurringPayinRegistrationId = $registration->Id;
        $cit->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cit->SecureModeReturnURL = "http://www.my-site.com/returnurl";
        $cit->StatementDescriptor = "lorem";
        $cit->Tag = "custom meta";
        $cit->BrowserInfo = $this->getBrowserInfo();

        $result = $this->_api->PayIns->CreateRecurringPayInRegistrationCIT($cit);

        $this->assertNotNull($result);
    }

    public function test_Create_Recurring_PayIn_CIT_Check_CardInfo()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $registration = $this->getRecurringPayin();

        $cit = new RecurringPayInCIT();
        $cit->RecurringPayinRegistrationId = $registration->Id;
        $cit->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cit->SecureModeReturnURL = "http://www.my-site.com/returnurl";
        $cit->StatementDescriptor = "lorem";
        $cit->Tag = "custom meta";
        $cit->BrowserInfo = $this->getBrowserInfo();

        $result = $this->_api->PayIns->CreateRecurringPayInRegistrationCIT($cit);

        $this->assertNotNull($result);
        $card_info = $result->PaymentDetails->CardInfo;
        $this->assertNotEmpty($card_info);
//        $this->assertNotEmpty($card_info->Brand);
//        $this->assertNotEmpty($card_info->Type);
//        $this->assertNotEmpty($card_info->IssuingBank);
    }

    public function test_Create_Recurring_PayIn_CIT_With_Debited_Funds_And_Fees()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $values = $this->getJohnsWalletWithMoneyAndCardId(1000);
        $walletId = $values["walletId"];
        $cardId = $values["cardId"];
        $user = $this->getJohn();

        $payIn = new \MangoPay\PayInRecurringRegistration();
        $payIn->AuthorId = $user->Id;
        $payIn->CardId = $cardId;
        $payIn->CreditedUserId = $user->Id;
        $payIn->CreditedWalletId = $walletId;
        $payIn->FirstTransactionDebitedFunds = new \MangoPay\Money();
        $payIn->FirstTransactionDebitedFunds->Amount = 10;
        $payIn->FirstTransactionDebitedFunds->Currency = 'EUR';
        $payIn->FirstTransactionFees = new \MangoPay\Money();
        $payIn->FirstTransactionFees->Amount = 1;
        $payIn->FirstTransactionFees->Currency = 'EUR';
        $billing = new \MangoPay\Billing();
        $billing->FirstName = 'John';
        $billing->LastName = 'Doe';
        $billing->Address = $this->getNewAddress();
        $shipping = new \MangoPay\Shipping();
        $shipping->FirstName = 'John';
        $shipping->LastName = 'Doe';
        $shipping->Address = $this->getNewAddress();
        $payIn->Shipping = $shipping;
        $payIn->Billing = $billing;
        $payIn->EndDate = 1833377810;
        $payIn->Migration = true;
        $payIn->NextTransactionDebitedFunds = new \MangoPay\Money();
        $payIn->NextTransactionDebitedFunds->Amount = 12;
        $payIn->NextTransactionDebitedFunds->Currency = 'EUR';
        $payIn->NextTransactionFees = new \MangoPay\Money();
        $payIn->NextTransactionFees->Amount = 1;
        $payIn->NextTransactionFees->Currency = 'EUR';
        $payIn->Frequency = "Daily";
        $payIn->FixedNextAmount = true;
        $payIn->FractionedPayment = false;

        $registration = $this->_api->PayIns->CreateRecurringRegistration($payIn);

        $cit = new RecurringPayInCIT();
        $cit->RecurringPayinRegistrationId = $registration->Id;
        $cit->IpAddress = "2001:0620:0000:0000:0211:24FF:FE80:C12C";
        $cit->SecureModeReturnURL = "http://www.my-site.com/returnurl";
        $cit->StatementDescriptor = "lorem";
        $cit->Tag = "custom meta";
        $cit->BrowserInfo = $this->getBrowserInfo();
        $cit->DebitedFunds = new Money();
        $cit->DebitedFunds->Amount = 10;
        $cit->DebitedFunds->Currency = 'EUR';
        $cit->Fees = new Money();
        $cit->Fees->Amount = 1;
        $cit->Fees->Currency = 'EUR';

        $result = $this->_api->PayIns->CreateRecurringPayInRegistrationCIT($cit);

        $this->assertNotNull($result);
    }

    public function test_Create_Recurring_Paypal_PayIn_CIT()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $registration = $this->getRecurringPayinRegistrationPaypal();

        $cit = new RecurringPayPalPayInCIT();
        $cit->RecurringPayinRegistrationId = $registration->Id;
        $cit->ReturnURL = "http://example.com";
        $cit->CancelURL = "http://example.net";

        $lineItem = new LineItem();
        $lineItem->Name = 'test item';
        $lineItem->Quantity = 1;
        $lineItem->UnitAmount = 100;
        $lineItem->TaxAmount = 0;

        $cit->LineItems = [$lineItem];

        $cit->ShippingPreference = "SET_PROVIDED_ADDRESS";
        $cit->Reference = "abcd-efgh-ijkl";
        $cit->StatementDescriptor = "Example123";

        $result = $this->_api->PayIns->CreateRecurringPayPalPayInCIT($cit);

        $this->assertNotNull($result);
        $this->assertNotNull($result->RecurringPayinRegistrationId);
        $this->assertEquals("PAYPAL", $result->PaymentType);
        $this->assertEquals("WEB", $result->ExecutionType);
        $this->assertEquals("CREATED", $result->Status);
        $this->assertEquals("PAYIN", $result->Type);
        $this->assertEquals("REGULAR", $result->Nature);
    }

    public function test_Create_Recurring_Paypal_PayIn_MIT()
    {
        self::$JohnsWalletWithMoney = null;// Reset the cache value

        $registration = $this->getRecurringPayinRegistrationPaypal();

        $mit = new RecurringPayPalPayInMIT();
        $mit->RecurringPayinRegistrationId = $registration->Id;
        $mit->ReturnURL = "http://example.com";
        $mit->CancelURL = "http://example.net";

        $mit->DebitedFunds = new \MangoPay\Money();
        $mit->DebitedFunds->Amount = 100;
        $mit->DebitedFunds->Currency = 'EUR';
        $mit->Fees = new \MangoPay\Money();
        $mit->Fees->Amount = 0;
        $mit->Fees->Currency = 'EUR';

        $lineItem = new LineItem();
        $lineItem->Name = 'test item';
        $lineItem->Quantity = 1;
        $lineItem->UnitAmount = 100;
        $lineItem->TaxAmount = 0;

        $mit->LineItems = [$lineItem];

        $mit->ShippingPreference = "SET_PROVIDED_ADDRESS";
        $mit->Reference = "abcd-efgh-ijkl";
        $mit->StatementDescriptor = "Example123";

        $result = $this->_api->PayIns->CreateRecurringPayPalPayInMIT($mit);

        $this->assertNotNull($result);
        $this->assertNotNull($result->RecurringPayinRegistrationId);
        $this->assertEquals("PAYPAL", $result->PaymentType);
        $this->assertEquals("WEB", $result->ExecutionType);
        $this->assertEquals("CREATED", $result->Status);
        $this->assertEquals("PAYIN", $result->Type);
        $this->assertEquals("REGULAR", $result->Nature);
    }

    public function test_PayIns_Google_Pay_Create()
    {
        $this->markTestIncomplete(
            "Cannot test Google Pay"
        );
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();

        // create Google Pay direct pay-in
        $googlePayPayIn = new \MangoPay\PayIn();
        $googlePayPayIn->CreditedWalletId = $wallet->Id;
        $googlePayPayIn->AuthorId = $user->Id;
        $googlePayPayIn->CreditedUserId = $user->Id;
        $googlePayPayIn->DebitedFunds = new \MangoPay\Money();
        $googlePayPayIn->DebitedFunds->Amount = 199;
        $googlePayPayIn->DebitedFunds->Currency = 'EUR';
        $googlePayPayIn->Fees = new \MangoPay\Money();
        $googlePayPayIn->Fees->Amount = 1;
        $googlePayPayIn->Fees->Currency = 'EUR';
        $googlePayPayIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        // payment data
        $googlePayPayIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsGooglePay();
        $googlePayPayIn->PaymentDetails->PaymentData = new \MangoPay\PaymentData();
        $googlePayPayIn->PaymentDetails->PaymentData->TransactionId = 'placeholder';
        $googlePayPayIn->PaymentDetails->PaymentData->Network = 'placeholder';
        $googlePayPayIn->PaymentDetails->PaymentData->TokenData = 'placeholder';

        $googlePayPayIn->PaymentDetails->StatementDescriptor = 'PHP';
        $googlePayPayIn->Tag = 'Create an Google card direct Payin';

        $createPayIn = $this->_api->PayIns->Create($googlePayPayIn, null);
        $this->assertTrue($createPayIn->Id > 0);
        $this->assertEquals($wallet->Id, $createPayIn->CreditedWalletId);
        $this->assertEquals($user->Id, $createPayIn->AuthorId);
        $this->assertEquals(PayInStatus::Succeeded, $createPayIn->DebitedFunds);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->DebitedFunds);
        $this->assertEquals(199, $createPayIn->DebitedFunds->Amount);
        $this->assertEquals("EUR", $createPayIn->DebitedFunds->Currency);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->Fees);
        $this->assertEquals(1, $createPayIn->Fees->Amount);
        $this->assertEquals("EUR", $createPayIn->Fees->Currency);
    }


    public function test_ExampleOf3DSecureV2_1()
    {
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);

        $payIn = $this->getNewPayInCardDirect3DSecure();
        $wallet = $this->_api->Wallets->Get($johnWallet->Id);
        $user = $this->getJohn();

        $this->assertNotNull($payIn->Id);
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
        $this->assertEquals(PayInStatus::Succeeded, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals($payIn->ExecutionDetails->Requested3DSVersion, "V2_1");
        $this->assertEquals($payIn->ExecutionDetails->Applied3DSVersion, "V2_1");
    }

    public function test_PayIns_Create_MbwayWeb()
    {
        $payIn = $this->getNewPayInMbwayWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Mbway, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsMbway', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_GooglePayDirectV2()
    {
        $this->markTestSkipped("Cannot test because payment data can't be generated in tests");
        $payIn = $this->getNewPayInGooglePayDirect();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::GooglePayV2, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsGooglePay', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $payIn->ExecutionDetails);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_MultibancoWeb()
    {
        $payIn = $this->getNewPayInMultibancoWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Multibanco, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsMultibanco', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Satispay_Web()
    {
        $payIn = $this->getNewPayInSatispayWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Satispay, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsSatispay', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_BlikWeb()
    {
        $payIn = $this->getNewPayInBlikWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Blik, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBlik', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_BlikWebWithCode()
    {
        $payIn = $this->getNewPayInBlikWeb(null, true);

        $this->assertNotNull($payIn->Id > 0);
        $this->assertNotNull($payIn->PaymentDetails->Code);
        $this->assertNotNull($payIn->PaymentDetails->IpAddress);
        $this->assertNotNull($payIn->PaymentDetails->BrowserInfo);
        $this->assertEquals(\MangoPay\PayInPaymentType::Blik, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBlik', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_KlarnaWeb()
    {
        $payIn = $this->getNewPayInKlarnaWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Klarna, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsKlarna', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Legacy_IdealWeb()
    {
        $payIn = $this->getLegacyPayInIdealWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Card, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsCard', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);
        $this->assertNotNull($payIn->PaymentDetails->BankName);
    }

    public function test_PayIns_Create_IdealWeb()
    {
        $payIn = $this->getNewPayInIdealWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Ideal, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsIdeal', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Giropay_Web()
    {
        $payIn = $this->getNewPayInGiropayWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Giropay, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsGiropay', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Swish_Web()
    {
        $payIn = $this->getNewPayInSwishWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Swish, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsSwish', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Twint_Web()
    {
        $payIn = $this->getNewPayInTwintWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Twint, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsTwint', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_PayIns_Create_Bancontact_Web()
    {
        $payIn = $this->getNewPayInBancontactWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::Bancontact, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBancontact', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }

    public function test_CardDirect_getPaymentMethodMetadata()
    {
        $payin = $this->getNewPayInCardDirect();

        $payment_method_metadata = new \MangoPay\PaymentMethodMetadata();
        $payment_method_metadata->Type = "BIN";
        $payment_method_metadata->Bin = ($payin->PaymentDetails->CardInfo->BIN);

        $result_metadata = $this->_api->PayIns->GetPaymentMethodMetadata($payment_method_metadata);

        $this->assertNotNull($result_metadata);
        $this->assertNotNull($result_metadata->IssuerCountryCode);
        $this->assertNotNull($result_metadata->IssuingBank);
        $this->assertNotNull($result_metadata->BinData);
        $this->assertNotNull($result_metadata->BinData[0]->CardType);
    }

    /**
     * @throws \Exception
     */
    public function test_createDepositPreauthorizedPayInWithoutComplement()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $wallet = $this->getJohnsWallet();

        $dto = new CreateCardPreAuthorizedDepositPayIn();
        $dto->DepositId = $deposit->Id;
        $dto->AuthorId = $user->Id;
        $dto->CreditedWalletId = $wallet->Id;

        $debitedFunds = new Money();
        $debitedFunds->Amount = 1000;
        $debitedFunds->Currency = "EUR";

        $fees = new Money();
        $fees->Amount = 0;
        $fees->Currency = "EUR";

        $dto->DebitedFunds = $debitedFunds;
        $dto->Fees = $fees;

        $payIn = $this->_api->PayIns->CreateDepositPreauthorizedPayInWithoutComplement($dto);

        $this->assertNotNull($payIn);
        $this->assertEquals("SUCCEEDED", $payIn->Status);
        $this->assertNotNull($payIn->DepositId);
    }

    /**
     * @throws \Exception
     */
    public function test_createDepositPreauthorizedPayInPriorToComplement()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $wallet = $this->getJohnsWallet();

        $dto = new CreateCardPreAuthorizedDepositPayIn();
        $dto->DepositId = $deposit->Id;
        $dto->AuthorId = $user->Id;
        $dto->CreditedWalletId = $wallet->Id;

        $debitedFunds = new Money();
        $debitedFunds->Amount = 1000;
        $debitedFunds->Currency = "EUR";

        $fees = new Money();
        $fees->Amount = 0;
        $fees->Currency = "EUR";

        $dto->DebitedFunds = $debitedFunds;
        $dto->Fees = $fees;

        $payIn = $this->_api->PayIns->CreateDepositPreauthorizedPayInPriorToComplement($dto);

        $this->assertNotNull($payIn);
        $this->assertEquals("SUCCEEDED", $payIn->Status);
        $this->assertNotNull($payIn->DepositId);
    }

    /**
     * @throws \Exception
     */
    public function test_createDepositPreauthorizedPayInComplement()
    {
        $user = $this->getJohn();
        $cardRegistration = $this->getUpdatedCardRegistration($user->Id);
        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $updateDepositDto = new UpdateDeposit();
        $updateDepositDto->PaymentStatus = "NO_SHOW_REQUESTED";
        $this->_api->Deposits->Update($deposit->Id, $updateDepositDto);
        $wallet = $this->getJohnsWallet();

        $dto = new CreateCardPreAuthorizedDepositPayIn();
        $dto->DepositId = $deposit->Id;
        $dto->AuthorId = $user->Id;
        $dto->CreditedWalletId = $wallet->Id;

        $debitedFunds = new Money();
        $debitedFunds->Amount = 1000;
        $debitedFunds->Currency = "EUR";

        $fees = new Money();
        $fees->Amount = 0;
        $fees->Currency = "EUR";

        $dto->DebitedFunds = $debitedFunds;
        $dto->Fees = $fees;

        $payIn = $this->_api->PayIns->CreateDepositPreauthorizedPayInComplement($dto);

        $this->assertNotNull($payIn);
        $this->assertEquals("SUCCEEDED", $payIn->Status);
        $this->assertNotNull($payIn->DepositId);
    }

    public function test_PayIns_Create_PayByBank_Web()
    {
        $payIn = $this->getNewPayInPayByBankWeb();

        $this->assertNotNull($payIn->Id > 0);
        $this->assertEquals(\MangoPay\PayInPaymentType::PayByBank, $payIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsPayByBank', $payIn->PaymentDetails);
        $this->assertEquals(\MangoPay\PayInExecutionType::Web, $payIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsWeb', $payIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $payIn->Status);
        $this->assertEquals('PAYIN', $payIn->Type);
        $this->assertEquals('REGULAR', $payIn->Nature);

        $fetchedPayIn = $this->_api->PayIns->Get($payIn->Id);
        $this->assertEquals($payIn->Id, $fetchedPayIn->Id);
    }
}
