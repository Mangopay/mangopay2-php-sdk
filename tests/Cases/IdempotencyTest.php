<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\ResponseException;

/**
 * Tests methods for idempotency support
 * See https://docs.mangopay.com/guide/idempotency-support/
 */
class IdempotencyTest extends Base
{
    // if post request called twice with no idempotency key, act independently
    public function test_NoIdempotencyKey_ActIndependently()
    {
        $user = $this->buildJohn();
        $user1 = $this->_api->Users->Create($user);
        $user2 = $this->_api->Users->Create($user);
        $this->assertTrue($user2->Id > $user1->Id);
    }

    // if post request called twice with same idempotency key, 2nd call is blocked

    /**
     * @throws \MangoPay\Libraries\Exception
     */
    public function test_SameIdempotencyKey_Blocks2ndCall()
    {
        $idempotencyKey = md5(uniqid());
        $user = $this->buildJohn();
        $this->expectException(ResponseException::class);
        $user1 = $this->_api->Users->Create($user);
        $user1 = $this->_api->Users->Create($user, $idempotencyKey);
        $user2 = $this->_api->Users->Create($user, $idempotencyKey);
        $this->assertTrue($user2 = null);
    }

    // if post request called twice with different idempotency key, act independently and responses may be retreived later
    public function test_DifferentIdempotencyKey_ActIndependentlyAndRetreivable()
    {
        $idempotencyKey1 = md5(uniqid());
        $idempotencyKey2 = md5(uniqid());
        $user = $this->buildJohn();
        $user1 = $this->_api->Users->Create($user, $idempotencyKey1);
        $user2 = $this->_api->Users->Create($user, $idempotencyKey2);
        $this->assertTrue($user2->Id > $user1->Id);

        // responses may be retreived later
        $resp1 = $this->_api->Responses->Get($idempotencyKey1);
        $resp2 = $this->_api->Responses->Get($idempotencyKey2);
        $this->assertTrue($resp1->Resource->Id == $user1->Id);
        $this->assertTrue($resp2->Resource->Id == $user2->Id);
    }

    public function test_GetIdempotencyKey_PreauthorizationCreate()
    {
        $key = md5(uniqid());
        $this->getJohnsCardPreAuthorization($key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\CardPreAuthorization', $resp->Resource);
    }

    public function test_GetIdempotencyKey_CardregistrationCreate()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR WITH MONEY';
        $wallet1 = $this->_api->Wallets->Create($wallet);
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $wallet1->Owners[0];
        $cardRegistration->Currency = 'EUR';
        $this->_api->CardRegistrations->Create($cardRegistration, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\CardRegistration', $resp->Resource);
    }

    /*function test_GetIdempotencyKey_HooksCreate(){
        $key = md5(uniqid());
        $hook = new \MangoPay\Hook();
        $hook->EventType = \MangoPay\EventType::PayinRefundFailed;
        $hook->Url = "http://test.com";
        $this->_api->Hooks->Create($hook, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf($resp->Resource, '\MangoPay\Hook');
    }*/

    public function test_GetIdempotencyKey_MandatesCreate()
    {
        $key = md5(uniqid());
        $account = $this->getJohnsAccount();
        $mandate = new \MangoPay\Mandate();
        $mandate->Tag = "Tag test";
        $mandate->BankAccountId = $account->Id;
        $mandate->ReturnURL = "http://www.mysite.com/returnURL/";
        $mandate->Culture = "FR";
        $this->_api->Mandates->Create($mandate, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\Mandate', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsCardWebCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->AuthorId = $user->Id;
        $payIn->CreditedUserId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->DebitedFunds->Amount = 1000;
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Currency = 'EUR';
        $payIn->Fees->Amount = 5;
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardType = 'CB_VISA_MASTERCARD';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = 'https://test.com';
        $payIn->ExecutionDetails->TemplateURL = 'https://TemplateURL.com';
        $payIn->ExecutionDetails->SecureMode = 'DEFAULT';
        $payIn->ExecutionDetails->Culture = 'fr';
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsCardDirectCreate()
    {
        $key = md5(uniqid());
        $johnWallet = $this->getJohnsWalletWithMoney();
        $beforeWallet = $this->_api->Wallets->Get($johnWallet->Id);
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $userId = $user->Id;
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistrationData($cardRegistration);
        $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);
        $card = $this->_api->Cards->Get($cardRegistration->CardId);
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $card->Id;
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsPreauthorizedDirectCreate()
    {
        $key = md5(uniqid());
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 100;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPreAuthorized();
        $payIn->PaymentDetails->PreauthorizationId = $cardPreAuthorization->Id;
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsBankWireDirectCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 10000;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->PaymentDetails->DeclaredFees = new \MangoPay\Money();
        $payIn->PaymentDetails->DeclaredFees->Amount = 0;
        $payIn->PaymentDetails->DeclaredFees->Currency = 'EUR';
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsDirectdebitWebCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWallet();
        $user = $this->getJohn();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $user->Id;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 100;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->DirectDebitType = "GIROPAY";
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
        $payIn->ExecutionDetails->ReturnURL = "http://www.mysite.com/returnURL/";
        $payIn->ExecutionDetails->Culture = "FR";
        $payIn->ExecutionDetails->TemplateURLOptions = new \MangoPay\PayInTemplateURLOptions();
        $payIn->ExecutionDetails->TemplateURLOptions->PAYLINE = "https://www.maysite.com/payline_template/";
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsDirectdebitDirectCreate()
    {
        $key = md5(uniqid());
        $wallet = $this->getJohnsWalletWithMoney();
        $user = $this->getJohn();
        $userId = $user->Id;
        $mandate = $this->getJohnsMandate();
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
        $payIn->PaymentDetails->MandateId = $mandate->Id;
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $this->_api->PayIns->Create($payIn, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayIn', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayinsCreateRefunds()
    {
        $key = md5(uniqid());
        $payIn = $this->getNewPayInCardDirect();
        $user = $this->getJohn();
        $refund = new \MangoPay\Refund();
        $refund->CreditedWalletId = $payIn->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $payIn->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $payIn->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $payIn->Fees->Amount;
        $refund->Fees->Currency = $payIn->Fees->Currency;
        $this->_api->PayIns->CreateRefund($payIn->Id, $refund, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\Refund', $resp->Resource);
    }

    public function test_GetIdempotencyKey_PayoutsBankwireCreate()
    {
        $key = md5(uniqid());
        $payIn = $this->getNewPayInCardDirect();
        $account = $this->getJohnsAccount();
        $payOut = new \MangoPay\PayOut();
        $payOut->Tag = 'DefaultTag';
        $payOut->AuthorId = $payIn->AuthorId;
        $payOut->CreditedUserId = $payIn->AuthorId;
        $payOut->DebitedFunds = new \MangoPay\Money();
        $payOut->DebitedFunds->Currency = 'EUR';
        $payOut->DebitedFunds->Amount = 10;
        $payOut->Fees = new \MangoPay\Money();
        $payOut->Fees->Currency = 'EUR';
        $payOut->Fees->Amount = 5;
        $payOut->DebitedWalletId = $payIn->CreditedWalletId;
        $payOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
        $payOut->MeanOfPaymentDetails->BankAccountId = $account->Id;
        $payOut->MeanOfPaymentDetails->BankWireRef = 'Johns payment';
        $payOut->MeanOfPaymentDetails->PayoutModeRequested = 'STANDARD';
        $this->_api->PayOuts->Create($payOut, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\PayOut', $resp->Resource);
    }

    public function test_GetIdempotencyKey_ReportsCreate()
    {
        $key = md5(uniqid());
        $reportRequest = new \MangoPay\ReportRequest();
        $reportRequest->ReportType = \MangoPay\ReportType::Transactions;
        $this->_api->Reports->Create($reportRequest, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\ReportRequest', $resp->Resource);
    }

    public function test_GetIdempotencyKey_TransfersCreateRefunds()
    {
        $key = md5(uniqid());
        $transfer = $this->getNewTransfer();
        $user = $this->getJohn();
        $refund = new \MangoPay\Refund();
        $refund->DebitedWalletId = $transfer->DebitedWalletId;
        $refund->CreditedWalletId = $transfer->CreditedWalletId;
        $refund->AuthorId = $user->Id;
        $refund->DebitedFunds = new \MangoPay\Money();
        $refund->DebitedFunds->Amount = $transfer->DebitedFunds->Amount;
        $refund->DebitedFunds->Currency = $transfer->DebitedFunds->Currency;
        $refund->Fees = new \MangoPay\Money();
        $refund->Fees->Amount = $transfer->Fees->Amount;
        $refund->Fees->Currency = $transfer->Fees->Currency;
        $this->_api->Transfers->CreateRefund($transfer->Id, $refund, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\Refund', $resp->Resource);
    }

    public function test_GetIdempotencyKey_TransfersCreate()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $walletWithMoney = $this->getJohnsWalletWithMoney();
        $wallet1 = new \MangoPay\Wallet();
        $wallet1->Owners = [$user->Id];
        $wallet1->Currency = 'EUR';
        $wallet1->Description = 'WALLET IN EUR FOR TRANSFER';
        $wallet = $this->_api->Wallets->Create($wallet1);
        $transfer = new \MangoPay\Transfer();
        $transfer->Tag = 'DefaultTag';
        $transfer->AuthorId = $user->Id;
        $transfer->CreditedUserId = $user->Id;
        $transfer->DebitedFunds = new \MangoPay\Money();
        $transfer->DebitedFunds->Currency = 'EUR';
        $transfer->DebitedFunds->Amount = 100;
        $transfer->Fees = new \MangoPay\Money();
        $transfer->Fees->Currency = 'EUR';
        $transfer->Fees->Amount = 0;
        $transfer->DebitedWalletId = $walletWithMoney->Id;
        $transfer->CreditedWalletId = $wallet->Id;
        $this->_api->Transfers->Create($transfer, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\Transfer', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateNaturals()
    {
        $key = md5(uniqid());
        $user = $this->buildJohn();
        $this->_api->Users->Create($user, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\UserNatural', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateLegals()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $user = new \MangoPay\UserLegal();
        $user->Name = "MartixSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = \MangoPay\LegalPersonType::Business;
        $user->HeadquartersAddress = $this->getNewAddress();
        $user->LegalRepresentativeFirstName = $john->FirstName;
        $user->LegalRepresentativeLastName = $john->LastName;
        $user->LegalRepresentativeAddress = $john->Address;
        $user->LegalRepresentativeEmail = $john->Email;
        $user->LegalRepresentativeBirthday = $john->Birthday;
        $user->LegalRepresentativeNationality = $john->Nationality;
        $user->LegalRepresentativeCountryOfResidence = $john->CountryOfResidence;
        $this->_api->Users->Create($user, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\UserLegal', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsIban()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsIBAN();
        $account->Details->IBAN = 'FR7630004000031234567890143';
        $account->Details->BIC = 'BNPAFRPP';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\BankAccount', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsGb()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsGB();
        $account->Details->AccountNumber = '63956474';
        $account->Details->SortCode = '200000';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\BankAccount', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsUs()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsUS();
        $account->Details->AccountNumber = '234234234234';
        $account->Details->ABA = '234334789';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\BankAccount', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsCa()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsCA();
        $account->Details->BankName = 'TestBankName';
        $account->Details->BranchCode = '12345';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->InstitutionNumber = '123';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\BankAccount', $resp->Resource);
    }

    public function test_GetIdempotencyKey_UsersCreateBankAccountsOther()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsOTHER();
        $account->Details->Type = 'OTHER';
        $account->Details->Country = 'FR';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->BIC = 'BINAADADXXX';
        $this->_api->Users->CreateBankAccount($john->Id, $account, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\BankAccount', $resp->Resource);
    }

    public function test_GetIdempotencyKey_KycDocumentsCreate()
    {
        $key = md5(uniqid());
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\KycDocument', $resp->Resource);
    }

    public function test_GetIdempotencyKey_WalletsCreate()
    {
        $key = md5(uniqid());
        $john = $this->getJohn();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = [$john->Id];
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR';
        $this->_api->Wallets->Create($wallet, $key);

        $resp = $this->_api->Responses->Get($key);

        $this->assertInstanceOf('\MangoPay\Wallet', $resp->Resource);
    }
}
