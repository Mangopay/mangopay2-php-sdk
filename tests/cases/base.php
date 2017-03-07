<?php

namespace MangoPay\Tests;

require_once '../simpletest/autorun.php';
require_once '../../vendor/autoload.php';
require_once '../mocks/mockStorageStrategy.php';

set_time_limit(0);

/**
 * Base class for test case classes
 */
abstract class Base extends \UnitTestCase {

    /** @var \MangoPay\MangoPayApi */
    protected $_api;

    /**
     * Test user (natural) - access by getJohn()
     * @var \MangoPay\UserNatural
     */
    public static $John;

    /**
     * Test user (legal) - access by getMatrix()
     * @var \MangoPay\UserLegal
     */
    public static $Matrix;

    /**
     * Test bank account belonging to John - access by getJohnsAccount()
     * @var \MangoPay\BankAccount
     */
    public static $JohnsAccount;

    /**
     * Test wallets belonging to John - access by getJohnsWallet()
     * @var \MangoPay\Wallet
     */
    public static $JohnsWallet;
    
    /**
     * Test Kyc Document belonging to John
     * @var \MangoPay\KycDocument
     */
    public static $JohnsKycDocument;
    
    /**
     * Test wallets belonging to John with money - access by getJohnsWalletWithMoney()
     * @var \MangoPay\Wallet
     */
    public static $JohnsWalletWithMoney;

    /**
     * Test pay-ins Card Web object
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInCardWeb;

    /** @var \MangoPay\PayInPaymentDetailsCard */
    public static $PayInPaymentDetailsCard;

    /** @var \MangoPay\PayInExecutionDetailsWeb */
    public static $PayInExecutionDetailsWeb;

    /**
     * Test pay-ins Card Web object
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInPaypalWeb;

    /**
     * Test pay-outs objects
     * @var \MangoPay\PayOut
     */
    public static $JohnsPayOutBankWire;
    public static $JohnsPayOutForCardDirect;

    /**
     * Test card registration object
     * @var \MangoPay\CardRegistration
     */
    public static $JohnsCardRegistration;

    /** @var \MangoPay\Hook */
    public static $JohnsHook;

    /**
     * Test Banking Alias IBAN
     * @var \MangoPay\BankingAliasIBAN
     */
    public static $JohnsBankingAliasIBAN;

    function __construct() {
        $this->_api = $this->buildNewMangoPayApi();
    }

    protected function buildNewMangoPayApi() {

        $api = new \MangoPay\MangoPayApi();

        // use test client credentails
        $api->Config->ClientId = 'sdk-unit-tests';

        // sandbox environment:
        $api->Config->BaseUrl = 'https://api.sandbox.mangopay.com';
        $api->Config->ClientPassword = 'cqFfFrWfCcb7UadHNxx2C9Lo6Djw8ZduLi7J9USTmu8bhxxpju';

        $api->OAuthTokenManager->RegisterCustomStorageStrategy(new \MangoPay\Tests\MockStorageStrategy());

        return $api;
    }
    
    /**
     * Creates new address
     * @return \MangoPay\Address
     */
    protected function getNewAddress() {
        $result = new \MangoPay\Address();
        
        $result->AddressLine1 = 'Address line 1';
        $result->AddressLine2 = 'Address line 2';
        $result->City = 'City';
        $result->Country = 'FR';
        $result->PostalCode = '11222';
        $result->Region = 'Region';
        
        return $result;
    }

    /**
     * @return \MangoPay\UserNatural
     */
    protected function buildJohn() {
		$user = new \MangoPay\UserNatural();
		$user->FirstName = "John";
		$user->LastName = "Doe";
		$user->Email = "john.doe@sample.org";
		$user->Address = $this->getNewAddress();
		$user->Birthday = mktime(0, 0, 0, 12, 21, 1975);
		$user->Nationality = "FR";
		$user->CountryOfResidence = "FR";
		$user->Occupation = "programmer";
		$user->IncomeRange = 3;
        return $user;
    }

    /**
     * Creates self::$John (test natural user) if not created yet
     * @return \MangoPay\UserNatural
     */
    protected function getJohn() {
        if (self::$John === null) {
            $user = $this->buildJohn();
            self::$John = $this->_api->Users->Create($user);
        }
        return self::$John;
    }

    /**
     * Creates new user
     * @return \MangoPay\UserNatural
     */
    protected function getNewJohn() {
        $user = $this->buildJohn();
        return $this->_api->Users->Create($user);
    }
    
    /**
     * Creates self::$Matrix (test legal user) if not created yet
     * @return \MangoPay\UserLegal
     */
    protected function getMatrix() {
        if (self::$Matrix === null) {
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
            self::$Matrix = $this->_api->Users->Create($user);
        }
        return self::$Matrix;
    }

    /**
     * Creates self::$JohnsAccount (bank account belonging to John) if not created yet
     * @return \MangoPay\BankAccount
     */
    protected function getJohnsAccount() {
        if (self::$JohnsAccount === null) {
            $john = $this->getJohn();
            $account = new \MangoPay\BankAccount();
            $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
            $account->OwnerAddress = $john->Address;
            $account->Details = new \MangoPay\BankAccountDetailsIBAN();
            $account->Details->IBAN = 'FR7618829754160173622224154';
            $account->Details->BIC = 'CMBRFR2BCME';
            self::$JohnsAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);
        }
        return self::$JohnsAccount;
    }

    /**
     * Creates self::$JohnsWallet (wallets belonging to John) if not created yet
     * @return \MangoPay\Wallet
     */
    protected function getJohnsWallet() {
        if (self::$JohnsWallet === null) {
            $john = $this->getJohn();

            $wallet = new \MangoPay\Wallet();
            $wallet->Owners = array($john->Id);
            $wallet->Currency = 'EUR';
            $wallet->Description = 'WALLET IN EUR';

            self::$JohnsWallet = $this->_api->Wallets->Create($wallet);
        }

        return self::$JohnsWallet;
    }

    /**
     * Creates self::$JohnsWalletWithMoney (wallets belonging to John) if not created yet
     * @return \MangoPay\Wallet
     */
    protected function getJohnsWalletWithMoney($amount = 10000) {

        if (self::$JohnsWalletWithMoney === null) {

            $john = $this->getJohn();
            // create wallet with money 
            $wallet = new \MangoPay\Wallet();
            $wallet->Owners = array($john->Id);
            $wallet->Currency = 'EUR';
            $wallet->Description = 'WALLET IN EUR WITH MONEY';

            self::$JohnsWalletWithMoney = $this->_api->Wallets->Create($wallet);

            $cardRegistration = new \MangoPay\CardRegistration();
            $cardRegistration->UserId = self::$JohnsWalletWithMoney->Owners[0];
            $cardRegistration->Currency = 'EUR';
            $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);

            $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistartionData($cardRegistration);
            $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

            $card = $this->_api->Cards->Get($cardRegistration->CardId);

            // create pay-in CARD DIRECT
            $payIn = new \MangoPay\PayIn();
            $payIn->CreditedWalletId = self::$JohnsWalletWithMoney->Id;
            $payIn->AuthorId = $cardRegistration->UserId;
            $payIn->DebitedFunds = new \MangoPay\Money();
            $payIn->DebitedFunds->Amount = $amount;
            $payIn->DebitedFunds->Currency = 'EUR';
            $payIn->Fees = new \MangoPay\Money();
            $payIn->Fees->Amount = 0;
            $payIn->Fees->Currency = 'EUR';

            // payment type as CARD
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
            $payIn->PaymentDetails->CardId = $card->Id;

            // execution type as DIRECT
            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
            $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
            // create Pay-In
            $this->_api->PayIns->Create($payIn);
        }

        return $this->_api->Wallets->Get(self::$JohnsWalletWithMoney->Id);
    }

    /**
     * Creates self::$JohnsKycDocument (KycDocument belonging to John) if not created yet
     * @return \MangoPay\KycDocument
     */
    protected function getJohnsKycDocument() {
        if (self::$JohnsKycDocument === null) {
            $john = $this->getJohn();

            $kycDocument = new \MangoPay\KycDocument();
            $kycDocument->Status = \MangoPay\KycDocumentStatus::Created;
            $kycDocument->Type = \MangoPay\KycDocumentType::IdentityProof;

            self::$JohnsKycDocument = $this->_api->Users->CreateKycDocument($john->Id, $kycDocument);
        }

        return self::$JohnsKycDocument;
    }

    /**
     * Creates self::$JohnsBankingAliasIBAN (Banking alias belonging to John) if not created yet
     * @return \MangoPay\BankingAliasIBAN
     */
    protected function getJohnsBankingAliasIBAN() {
        if (self::$JohnsBankingAliasIBAN === null) {
            $john = $this->getJohn();
            $wallet = $this->getJohnsWallet();

            $bankingAliasIBAN = new \MangoPay\BankingAliasIBAN();
            $bankingAliasIBAN->CreditedUserId = $john->Id;
            $bankingAliasIBAN->WalletId = $wallet->Id;
            $bankingAliasIBAN->OwnerName = $john->FirstName;
            $bankingAliasIBAN->Country = "LU";
            $bankingAliasIBAN->Active = "true";

            self::$JohnsBankingAliasIBAN = $this->_api->BankingAliases->Create($bankingAliasIBAN, $wallet->Id);
        }

        return self::$JohnsBankingAliasIBAN;
    }

    /**
     * @return \MangoPay\PayInPaymentDetailsCard
     */
    private function getPayInPaymentDetailsCard() {
        if (self::$PayInPaymentDetailsCard === null) {
            self::$PayInPaymentDetailsCard = new \MangoPay\PayInPaymentDetailsCard();
            self::$PayInPaymentDetailsCard->CardType = 'CB_VISA_MASTERCARD';
        }

        return self::$PayInPaymentDetailsCard;
    }

    /**
     * @return \MangoPay\PayInExecutionDetailsWeb
     */
    private function getPayInExecutionDetailsWeb() {
        if (self::$PayInExecutionDetailsWeb === null) {
            self::$PayInExecutionDetailsWeb = new \MangoPay\PayInExecutionDetailsWeb();
            self::$PayInExecutionDetailsWeb->ReturnURL = 'https://test.com';
            self::$PayInExecutionDetailsWeb->TemplateURL = 'https://TemplateURL.com';
            self::$PayInExecutionDetailsWeb->SecureMode = 'DEFAULT';
            self::$PayInExecutionDetailsWeb->Culture = 'fr';
        }

        return self::$PayInExecutionDetailsWeb;
    }

    /**
     * Creates Pay-In Card Web object
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInCardWeb() {
        if (self::$JohnsPayInCardWeb === null) {
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
            $payIn->PaymentDetails = $this->getPayInPaymentDetailsCard();
            $payIn->ExecutionDetails = $this->getPayInExecutionDetailsWeb();

            self::$JohnsPayInCardWeb = $this->_api->PayIns->Create($payIn);
        }

        return self::$JohnsPayInCardWeb;
    }

    /**
     * Creates Pay-In Card Direct object
     * @return \MangoPay\PayIn
     */
    protected function getNewPayInCardDirect($userId = null) {
        $wallet = $this->getJohnsWalletWithMoney();
        if (is_null($userId)){
            $user = $this->getJohn();
            $userId = $user->Id;
        }
        
        $cardRegistration = new \MangoPay\CardRegistration();
        $cardRegistration->UserId = $userId;
        $cardRegistration->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        $cardRegistration->RegistrationData = $this->getPaylineCorrectRegistartionData($cardRegistration);
        $cardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

        $card = $this->_api->Cards->Get($cardRegistration->CardId);

        // create pay-in CARD DIRECT
        $payIn = new \MangoPay\PayIn();
        $payIn->CreditedWalletId = $wallet->Id;
        $payIn->AuthorId = $userId;
        $payIn->DebitedFunds = new \MangoPay\Money();
        $payIn->DebitedFunds->Amount = 10000;
        $payIn->DebitedFunds->Currency = 'EUR';
        $payIn->Fees = new \MangoPay\Money();
        $payIn->Fees->Amount = 0;
        $payIn->Fees->Currency = 'EUR';
        // payment type as CARD
        $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsCard();
        $payIn->PaymentDetails->CardId = $card->Id;
        // execution type as DIRECT
        $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
        $payIn->ExecutionDetails->SecureModeReturnURL = 'http://test.com';
        return $this->_api->PayIns->Create($payIn);
    }

    /**
     * Creates Pay-In direct debit direct object
     * @return \MangoPay\PayIn
     */
     protected function getNewPayInDirectDebitDirect($userId = null) {
         $wallet = $this->getJohnsWalletWithMoney();
         if (is_null($userId)){
             $user = $this->getJohn();
             $userId = $user->Id;
         }
         $mandate = $this->getJohnsMandate();

         // create pay-in CARD DIRECT
         $payIn = new \MangoPay\PayIn();
         $payIn->CreditedWalletId = $wallet->Id;
         $payIn->AuthorId = $userId;
         $payIn->DebitedFunds = new \MangoPay\Money();
         $payIn->DebitedFunds->Amount = 10000;
         $payIn->DebitedFunds->Currency = 'EUR';
         $payIn->Fees = new \MangoPay\Money();
         $payIn->Fees->Amount = 0;
         $payIn->Fees->Currency = 'EUR';
         // payment type as CARD
         $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsDirectDebit();
         $payIn->PaymentDetails->MandateId = $mandate->Id;
         // execution type as DIRECT
         $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsDirect();
         return $this->_api->PayIns->Create($payIn);
     }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\PayOut
     */
    protected function getJohnsPayOutBankWire() {
        if (self::$JohnsPayOutBankWire === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();
            $account = $this->getJohnsAccount();

            $payOut = new \MangoPay\PayOut();
            $payOut->Tag = 'DefaultTag';
            $payOut->AuthorId = $user->Id;
            $payOut->CreditedUserId = $user->Id;
            $payOut->DebitedFunds = new \MangoPay\Money();
            $payOut->DebitedFunds->Currency = 'EUR';
            $payOut->DebitedFunds->Amount = 10;
            $payOut->Fees = new \MangoPay\Money();
            $payOut->Fees->Currency = 'EUR';
            $payOut->Fees->Amount = 5;

            $payOut->DebitedWalletId = $wallet->Id;
            $payOut->MeanOfPaymentDetails = new \MangoPay\PayOutPaymentDetailsBankWire();
            $payOut->MeanOfPaymentDetails->BankAccountId = $account->Id;
            $payOut->MeanOfPaymentDetails->BankWireRef = 'Johns payment';

            self::$JohnsPayOutBankWire = $this->_api->PayOuts->Create($payOut);
        }

        return self::$JohnsPayOutBankWire;
    }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\PayOut
     */
    protected function getJohnsPayOutForCardDirect() {
        if (self::$JohnsPayOutForCardDirect === null) {
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

            self::$JohnsPayOutForCardDirect = $this->_api->PayOuts->Create($payOut);
        }

        return self::$JohnsPayOutForCardDirect;
    }

    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\Transfer
     */
    protected function getNewTransfer() {
        $user = $this->getJohn();
        $walletWithMoney = $this->getJohnsWalletWithMoney();
        $wallet = new \MangoPay\Wallet();
        $wallet->Owners = array($user->Id);
        $wallet->Currency = 'EUR';
        $wallet->Description = 'WALLET IN EUR FOR TRANSFER';
        $wallet = $this->_api->Wallets->Create($wallet);

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

        return $this->_api->Transfers->Create($transfer);
    }

    /**
     * Creates refund object for transfer
     * @return \MangoPay\Refund
     */
    protected function getNewRefundForTransfer($transfer) {
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

        return $this->_api->Transfers->CreateRefund($transfer->Id, $refund);
    }

    /**
     * Creates refund object for PayIn
     * @return \MangoPay\Refund
     */
    protected function getNewRefundForPayIn($payIn) {
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

        return $this->_api->PayIns->CreateRefund($payIn->Id, $refund);
    }

    /**
     * Creates card registration object
     * @return \MangoPay\CardRegistration
     */
    protected function getJohnsCardRegistration() {
        if (self::$JohnsCardRegistration === null) {
            $user = $this->getJohn();

            $cardRegistration = new \MangoPay\CardRegistration();
            $cardRegistration->UserId = $user->Id;
            $cardRegistration->Currency = 'EUR';

            self::$JohnsCardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);
        }

        return self::$JohnsCardRegistration;
    }

    /**
     * Creates card registration object
     * @return \MangoPay\CardPreAuthorization
     */
    protected function getJohnsCardPreAuthorization($idempotencyKey = null) {
            $user = $this->getJohn();
            $cardRegistration = new \MangoPay\CardRegistration();
            $cardRegistration->UserId = $user->Id;
            $cardRegistration->Currency = 'EUR';
            $newCardRegistration = $this->_api->CardRegistrations->Create($cardRegistration);

            $registrationData = $this->getPaylineCorrectRegistartionData($newCardRegistration);
            $newCardRegistration->RegistrationData = $registrationData;
            $getCardRegistration = $this->_api->CardRegistrations->Update($newCardRegistration);

            $cardPreAuthorization = new \MangoPay\CardPreAuthorization();
            $cardPreAuthorization->AuthorId = $user->Id;
            $cardPreAuthorization->DebitedFunds = new \MangoPay\Money();
            $cardPreAuthorization->DebitedFunds->Currency = "EUR";
            $cardPreAuthorization->DebitedFunds->Amount = 10000;
            $cardPreAuthorization->CardId = $getCardRegistration->CardId;
            $cardPreAuthorization->SecureModeReturnURL = 'http://test.com';

            return $this->_api->CardPreAuthorizations->Create($cardPreAuthorization, $idempotencyKey);
    }

    /**
     * Get registration data from Payline service
     * @param \MangoPay\CardRegistration $cardRegistration
     * @return string
     */
    protected function getPaylineCorrectRegistartionData($cardRegistration) {

		/*
		 ****** DO NOT use this code in a production environment - it is just for unit tests. In production you are not allowed to have the user's card details pass via your server (which is what is required to use this code here) *******
		 */
        $data = 'data=' . $cardRegistration->PreregistrationData .
                '&accessKeyRef=' . $cardRegistration->AccessKey .
                '&cardNumber=4970100000000154' .
                '&cardExpirationDate=1224' .
                '&cardCvx=123';

        $curlHandle = curl_init($cardRegistration->CardRegistrationURL);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlHandle, CURLOPT_POST, true);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($curlHandle);
        if ($response === false && curl_errno($curlHandle) != 0)
            throw new \Exception('cURL error: ' . curl_error($curlHandle));

        curl_close($curlHandle);

        return $response;
    }

	/**
     * Creates Pay-In Card Web object
     * @return \MangoPay\PayIn
     */
    protected function getJohnsPayInPaypalWeb() {
        if (self::$JohnsPayInPaypalWeb === null) {
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
            $payIn->PaymentDetails = new \MangoPay\PayInPaymentDetailsPaypal();
            $payIn->ExecutionDetails = new \MangoPay\PayInExecutionDetailsWeb();
            $payIn->ExecutionDetails->ReturnURL = 'https://test.com';

            self::$JohnsPayInPaypalWeb = $this->_api->PayIns->Create($payIn);
        }

        return self::$JohnsPayInPaypalWeb;
    }

    /**
     * Creates self::$JohnsHook
     * @return \MangoPay\Hook
     */
    protected function getJohnHook() {
        if (self::$JohnsHook === null) {

            $pagination = new \MangoPay\Pagination(1, 1);
            $list = $this->_api->Hooks->GetAll($pagination);

            if (isset($list[0])){
                self::$JohnsHook = $list[0];
            } else {
                $hook = new \MangoPay\Hook();
                $hook->EventType = \MangoPay\EventType::PayinNormalCreated;
                $hook->Url = "http://test.com";
                self::$JohnsHook = $this->_api->Hooks->Create($hook);
            }
        }

        return self::$JohnsHook;
    }

     /**
      * Creates mandate belonging to John
      * @return \MangoPay\Mandate
      */
     protected function getJohnsMandate() {
         $account = $this->getJohnsAccount();

         $mandate = new \MangoPay\Mandate();
         $mandate->Tag = "Tag test";
         $mandate->BankAccountId = $account->Id;
         $mandate->ReturnURL = "http://www.mysite.com/returnURL/";
         $mandate->Culture = "FR";

         return $this->_api->Mandates->Create($mandate);
    }

    /**
     * Asserts the passed entities have identical values (by assertIdentical())
     * but ONLY FOR INPUT PROPERTIES, i.e. properties that are accepted by Create methods:
     * IGNORES SYSTEM PROPERTIES set by the Mango API (Id, CreationDate etc).
     *
     * @param \MangoPay\Libraries\EntityBase $entity1
     * @param \MangoPay\Libraries\EntityBase $entity2
     */
    protected function assertIdenticalInputProps($entity1, $entity2) {

        if (is_a($entity1, '\MangoPay\UserNatural')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->FirstName, $entity2->FirstName);
            $this->assertIdentical($entity1->LastName, $entity2->LastName);
            $this->assertIdentical($entity1->Email, $entity2->Email);
            $this->assertNotNull($entity1->Address);
            $this->assertNotNull($entity2->Address);
            $this->assertEqual($entity1->Address->AddressLine1, $entity1->Address->AddressLine1);
            $this->assertEqual($entity1->Address->AddressLine2, $entity1->Address->AddressLine2);
            $this->assertEqual($entity1->Address->City, $entity1->Address->City);
            $this->assertEqual($entity1->Address->Country, $entity1->Address->Country);
            $this->assertEqual($entity1->Address->PostalCode, $entity1->Address->PostalCode);
            $this->assertEqual($entity1->Address->Region, $entity1->Address->Region);
            $this->assertIdentical($entity1->Birthday, $entity2->Birthday);
            $this->assertIdentical($entity1->Nationality, $entity2->Nationality);
            $this->assertIdentical($entity1->CountryOfResidence, $entity2->CountryOfResidence);
            $this->assertIdentical($entity1->Occupation, $entity2->Occupation);
            $this->assertIdentical($entity1->IncomeRange, $entity2->IncomeRange);
        } elseif (is_a($entity1, '\MangoPay\UserLegal')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->Name, $entity2->Name);
            $this->assertNotNull($entity1->HeadquartersAddress);
            $this->assertNotNull($entity2->HeadquartersAddress);
            $this->assertEqual($entity1->HeadquartersAddress->AddressLine1, $entity1->HeadquartersAddress->AddressLine1);
            $this->assertEqual($entity1->HeadquartersAddress->AddressLine2, $entity1->HeadquartersAddress->AddressLine2);
            $this->assertEqual($entity1->HeadquartersAddress->City, $entity1->HeadquartersAddress->City);
            $this->assertEqual($entity1->HeadquartersAddress->Country, $entity1->HeadquartersAddress->Country);
            $this->assertEqual($entity1->HeadquartersAddress->PostalCode, $entity1->HeadquartersAddress->PostalCode);
            $this->assertEqual($entity1->HeadquartersAddress->Region, $entity1->HeadquartersAddress->Region);
            $this->assertIdentical($entity1->LegalRepresentativeFirstName, $entity2->LegalRepresentativeFirstName);
            $this->assertIdentical($entity1->LegalRepresentativeLastName, $entity2->LegalRepresentativeLastName);


            //$this->assertIdentical($entity1->LegalRepresentativeAddress, $entity2->LegalRepresentativeAddress, "***** TEMPORARY API ISSUE: RETURNED OBJECT MISSES THIS PROP AFTER CREATION *****");
            $this->assertNotNull($entity1->LegalRepresentativeAddress);
            $this->assertNotNull($entity2->LegalRepresentativeAddress);
            $this->assertEqual($entity1->LegalRepresentativeAddress->AddressLine1, $entity1->LegalRepresentativeAddress->AddressLine1);
            $this->assertEqual($entity1->LegalRepresentativeAddress->AddressLine2, $entity1->LegalRepresentativeAddress->AddressLine2);
            $this->assertEqual($entity1->LegalRepresentativeAddress->City, $entity1->LegalRepresentativeAddress->City);
            $this->assertEqual($entity1->LegalRepresentativeAddress->Country, $entity1->LegalRepresentativeAddress->Country);
            $this->assertEqual($entity1->LegalRepresentativeAddress->PostalCode, $entity1->LegalRepresentativeAddress->PostalCode);
            $this->assertEqual($entity1->LegalRepresentativeAddress->Region, $entity1->LegalRepresentativeAddress->Region);


            $this->assertIdentical($entity1->LegalRepresentativeEmail, $entity2->LegalRepresentativeEmail);
            $this->assertIdentical($entity1->LegalRepresentativeBirthday, $entity2->LegalRepresentativeBirthday, "***** TEMPORARY API ISSUE: RETURNED OBJECT HAS THIS PROP CHANGED FROM TIMESTAMP INTO ISO STRING AFTER CREATION *****");
            $this->assertIdentical($entity1->LegalRepresentativeNationality, $entity2->LegalRepresentativeNationality);
            $this->assertIdentical($entity1->LegalRepresentativeCountryOfResidence, $entity2->LegalRepresentativeCountryOfResidence);
        } elseif (is_a($entity1, '\MangoPay\BankAccount')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->UserId, $entity2->UserId);
            $this->assertIdentical($entity1->Type, $entity2->Type);
            $this->assertIdentical($entity1->OwnerName, $entity2->OwnerName);
            $this->assertNotNull($entity1->OwnerAddress);
            $this->assertNotNull($entity2->OwnerAddress);
            $this->assertEqual($entity1->OwnerAddress->AddressLine1, $entity1->OwnerAddress->AddressLine1);
            $this->assertEqual($entity1->OwnerAddress->AddressLine2, $entity1->OwnerAddress->AddressLine2);
            $this->assertEqual($entity1->OwnerAddress->City, $entity1->OwnerAddress->City);
            $this->assertEqual($entity1->OwnerAddress->Country, $entity1->OwnerAddress->Country);
            $this->assertEqual($entity1->OwnerAddress->PostalCode, $entity1->OwnerAddress->PostalCode);
            $this->assertEqual($entity1->OwnerAddress->Region, $entity1->OwnerAddress->Region);
            if ($entity1->Type == 'IBAN') {
                $this->assertIdentical($entity1->Details->IBAN, $entity2->Details->IBAN);
                $this->assertIdentical($entity1->Details->BIC, $entity2->Details->BIC);
            } elseif ($entity1->Type == 'GB') {
                $this->assertIdentical($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
                $this->assertIdentical($entity1->Details->SortCode, $entity2->Details->SortCode);
            } elseif ($entity1->Type == 'US') {
                $this->assertIdentical($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
                $this->assertIdentical($entity1->Details->ABA, $entity2->Details->ABA);
            } elseif ($entity1->Type == 'CA') {
                $this->assertIdentical($entity1->Details->BankName, $entity2->Details->BankName);
                $this->assertIdentical($entity1->Details->InstitutionNumber, $entity2->Details->InstitutionNumber);
                $this->assertIdentical($entity1->Details->BranchCode, $entity2->Details->BranchCode);
                $this->assertIdentical($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
            } elseif ($entity1->Type == 'OTHER') {
                $this->assertIdentical($entity1->Details->Type, $entity2->Details->Type);
                $this->assertIdentical($entity1->Details->Country, $entity2->Details->Country);
                $this->assertIdentical($entity1->Details->BIC, $entity2->Details->BIC);
                $this->assertIdentical($entity1->Details->AccountNumber, $entity2->Details->AccountNumber);
            }
        } elseif (is_a($entity1, '\MangoPay\Card')) {
            $this->assertIdentical($entity1->ExpirationDate, $entity2->ExpirationDate);
            $this->assertIdentical($entity1->Alias, $entity2->Alias);
            $this->assertIdentical($entity1->CardType, $entity2->CardType);
            $this->assertIdentical($entity1->Currency, $entity2->Currency);
        } elseif (is_a($entity1, '\MangoPay\PayIn')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdenticalInputProps($entity1->PaymentDetails, $entity2->PaymentDetails);
            $this->assertIdenticalInputProps($entity1->ExecutionDetails, $entity2->ExecutionDetails);
        } elseif (is_a($entity1, '\MangoPay\PayInPaymentDetailsCard')) {
            $this->assertIdentical($entity1->CardType, $entity2->CardType);
            $this->assertIdentical($entity1->CardId, $entity2->CardId);
        } elseif (is_a($entity1, 'MangoPay\PayInExecutionDetailsDirect')) {
            $this->assertIdentical($entity1->SecureMode, $entity2->SecureMode);
            $this->assertIdentical($entity1->SecureModeReturnURL, $entity2->SecureModeReturnURL);
            $this->assertIdentical($entity1->SecureModeRedirectURL, $entity2->SecureModeRedirectURL);
        } elseif (is_a($entity1, '\MangoPay\PayInExecutionDetailsWeb')) {
            $this->assertIdentical($entity1->TemplateURL, $entity2->TemplateURL);
            $this->assertIdentical($entity1->Culture, $entity2->Culture);
            $this->assertIdentical($entity1->SecureMode, $entity2->SecureMode);
            $this->assertIdentical($entity1->RedirectURL, $entity2->RedirectURL);
            $this->assertIdentical($entity1->ReturnURL, $entity2->ReturnURL);
        } elseif (is_a($entity1, '\MangoPay\PayOut')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdenticalInputProps($entity1->MeanOfPaymentDetails, $entity2->MeanOfPaymentDetails);
        } elseif (is_a($entity1, '\MangoPay\Transfer')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
        } elseif (is_a($entity1, '\MangoPay\PayOutPaymentDetailsBankWire')) {
            $this->assertIdentical($entity1->BankAccountId, $entity2->BankAccountId);
            $this->assertIdentical($entity1->BankWireRef, $entity2->BankWireRef);
        } elseif (is_a($entity1, '\MangoPay\Transaction')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdentical($entity1->Status, $entity2->Status);
        } elseif (is_a($entity1, '\MangoPay\Money')) {
            $this->assertIdentical($entity1->Currency, $entity2->Currency);
            $this->assertIdentical($entity1->Amount, $entity2->Amount);
        } elseif (is_a($entity1, '\MangoPay\KycDocument')) {
            $this->assertIdentical($entity1->Type, $entity2->Type);
            $this->assertIdentical($entity1->Status, $entity2->Status);
            $this->assertIdentical($entity1->UserId, $entity2->UserId);
        } elseif(is_a($entity1, '\MangoPay\PayInPaymentDetailsPaypal')) {
            // TODO Add the right comparison
        } else {
            throw new \Exception("Unsupported type " . get_class($entity1));
        }
    }

    protected function getEntityFromList($entityId, $list){

        foreach ($list as $entity) {
            if($entityId == $entity->Id)
                return $entity;
        }
    }
}
