<?php
namespace MangoPay\Tests;
require_once '../simpletest/autorun.php';
require_once '../../MangoPaySDK/mangoPayApi.inc';

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
     * Test pay-ins object
     * @var \MangoPay\PayIn
     */
    public static $JohnsPayInCardWeb;
    /** @var \MangoPay\PayInPaymentDetailsCard */
    public static $PayInPaymentDetailsCard;
    /** @var \MangoPay\PayInExecutionDetailsWeb */
    public static $PayInExecutionDetailsWeb;

    /**
     * Test pay-ins object
     * @var \MangoPay\PayOut
     */
    public static $JohnsPayOutBankWire;
    
    /**
     * Test transfer object
     * @var \MangoPay\Transfer
     */
    public static $JohnsTransfer;
    
    function __construct() {
        $this->_api = new \MangoPay\MangoPayApi();
    }

    /**
     * Creates self::$John (test natural user) if not created yet
     * @return \MangoPay\UserNatural
     */
    protected function getJohn() {
        if (self::$John === null) {
            $user = new \MangoPay\UserNatural();
            $user->FirstName = "John";
            $user->LastName = "Doe";
            $user->Email = "john.doe@sample.org";
            $user->Address = "Some Address";
            $user->Birthday = mktime(0,0,0, 12, 21, 1975);
            $user->Nationality = "FR";
            $user->CountryOfResidence = "FR";
            $user->Occupation = "programmer";
            $user->IncomeRange = 3;
            self::$John = $this->_api->Users->Create($user);
        }
        return self::$John;
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
            $user->LegalPersonType = "BUSINESS";
            $user->HeadquartersAddress = "Some Address";
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
            $account->Type = 'IBAN';
            $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
            $account->OwnerAddress = $john->Address;
            $account->IBAN = 'AD12 0001 2030 2003 5910 0100';
            $account->BIC = 'BINAADADXXX';
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
     * @return \MangoPay\PayInPaymentDetailsCard
     */
    private function getPayInPaymentDetailsCard() {
        if (self::$PayInPaymentDetailsCard === null) {
            self::$PayInPaymentDetailsCard = new \MangoPay\PayInPaymentDetailsCard();
            self::$PayInPaymentDetailsCard->CardType = 'AMEX';
            self::$PayInPaymentDetailsCard->ReturnURL = 'https://test.com';
        }
        
        return self::$PayInPaymentDetailsCard;
    }
    
    /**
     * @return \MangoPay\PayInExecutionDetailsWeb
     */
    private function getPayInExecutionDetailsWeb() {
        if (self::$PayInExecutionDetailsWeb === null) {
            self::$PayInExecutionDetailsWeb = new \MangoPay\PayInExecutionDetailsWeb();
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
            $payOut->MeanOfPaymentDetails->Communication = 'Communication text';

            self::$JohnsPayOutBankWire = $this->_api->PayOuts->Create($payOut);
        }
        
        return self::$JohnsPayOutBankWire;
    }
    
    /**
     * Creates Pay-Out  Bank Wire object
     * @return \MangoPay\PayOut
     */
    protected function getJohnsTransfer() {
        if (self::$JohnsTransfer === null) {
            $wallet = $this->getJohnsWallet();
            $user = $this->getJohn();
            
            $transfer = new \MangoPay\Transfer();
            $transfer->Tag = 'DefaultTag';
            $transfer->AuthorId = $user->Id;
            $transfer->CreditedUserId = $user->Id;
            $transfer->DebitedFunds = new \MangoPay\Money();
            $transfer->DebitedFunds->Currency = 'EUR';
            $transfer->DebitedFunds->Amount = 100;
            $transfer->Fees = new \MangoPay\Money();
            $transfer->Fees->Currency = 'EUR';
            $transfer->Fees->Amount = 10;

            $transfer->DebitedWalletId = $wallet->Id;
            $transfer->CreditedWalletId = $wallet->Id;

            self::$JohnsTransfer = $this->_api->Transfers->Create($transfer);
        }
        
        return self::$JohnsTransfer;
    }
    
    /**
     * Asserts the passed entities have identical values (by assertIdentical())
     * but ONLY FOR INPUT PROPERTIES, i.e. properties that are accepted by Create methods:
     * IGNORES SYSTEM PROPERTIES set by the Mango API (Id, CreationDate etc).
     * 
     * @param \MangoPay\EntityBase $entity1
     * @param \MangoPay\EntityBase $entity2
     */
    protected function assertIdenticalInputProps($entity1, $entity2) {

        if (is_a($entity1, '\MangoPay\UserNatural')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->FirstName, $entity2->FirstName);
            $this->assertIdentical($entity1->LastName, $entity2->LastName);
            $this->assertIdentical($entity1->Email, $entity2->Email);
            $this->assertIdentical($entity1->Address, $entity2->Address);
            $this->assertIdentical($entity1->Birthday, $entity2->Birthday);
            $this->assertIdentical($entity1->Nationality, $entity2->Nationality);
            $this->assertIdentical($entity1->CountryOfResidence, $entity2->CountryOfResidence);
            $this->assertIdentical($entity1->Occupation, $entity2->Occupation);
            $this->assertIdentical($entity1->IncomeRange, $entity2->IncomeRange);

        } elseif (is_a($entity1, '\MangoPay\UserLegal')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->PersonType, $entity2->PersonType);
            $this->assertIdentical($entity1->Name, $entity2->Name);
            $this->assertIdentical($entity1->HeadquartersAddress, $entity2->HeadquartersAddress);
            $this->assertIdentical($entity1->LegalRepresentativeFirstName, $entity2->LegalRepresentativeFirstName);
            $this->assertIdentical($entity1->LegalRepresentativeLastName, $entity2->LegalRepresentativeLastName);
            $this->assertIdentical($entity1->LegalRepresentativeAddress, $entity2->LegalRepresentativeAddress, "***** TEMPORARY API ISSUE: RETURNED OBJECT MISSES THIS PROP AFTER CREATION *****");
            $this->assertIdentical($entity1->LegalRepresentativeEmail, $entity2->LegalRepresentativeEmail);
            $this->assertIdentical($entity1->LegalRepresentativeBirthday, $entity2->LegalRepresentativeBirthday, "***** TEMPORARY API ISSUE: RETURNED OBJECT HAS THIS PROP CHANGED FROM TIMESTAMP INTO ISO STRING AFTER CREATION *****");
            $this->assertIdentical($entity1->LegalRepresentativeNationality, $entity2->LegalRepresentativeNationality);
            $this->assertIdentical($entity1->LegalRepresentativeCountryOfResidence, $entity2->LegalRepresentativeCountryOfResidence);

        } elseif (is_a($entity1, '\MangoPay\BankAccount')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->UserId, $entity2->UserId);
            $this->assertIdentical($entity1->Type, $entity2->Type);
            $this->assertIdentical($entity1->OwnerName, $entity2->OwnerName);
            $this->assertIdentical($entity1->OwnerAddress, $entity2->OwnerAddress);
            $this->assertIdentical($entity1->IBAN, $entity2->IBAN);
            $this->assertIdentical($entity1->BIC, $entity2->BIC);
            
        } elseif (is_a($entity1, '\MangoPay\PayIn')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            
        } elseif (is_a($entity1, '\MangoPay\Card')) {
            $this->assertIdentical($entity1->CardType, $entity2->CardType);
            $this->assertIdentical($entity1->RedirectURL, $entity2->RedirectURL);
            $this->assertIdentical($entity1->ReturnURL, $entity2->ReturnURL);
            
        } elseif (is_a($entity1, '\MangoPay\Web')) {
            $this->assertIdentical($entity1->TemplateURL, $entity2->TemplateURL);
            $this->assertIdentical($entity1->Culture, $entity2->Culture);
            $this->assertIdentical($entity1->SecureMode, $entity2->SecureMode);
            
        } elseif (is_a($entity1, '\MangoPay\PayOut')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdenticalInputProps($entity1->MeanOfPayment, $entity2->MeanOfPayment);
            
        } elseif (is_a($entity1, '\MangoPay\Transfer')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdentical($entity1->AuthorId, $entity2->AuthorId);
            $this->assertIdentical($entity1->CreditedUserId, $entity2->CreditedUserId);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            
        } elseif (is_a($entity1, '\MangoPay\BankWirePayOut')) {
            $this->assertIdentical($entity1->BankAccountId, $entity2->BankAccountId);
            $this->assertIdentical($entity1->Communication, $entity2->Communication);
            
        } elseif (is_a($entity1, '\MangoPay\Transaction')) {
            $this->assertIdentical($entity1->Tag, $entity2->Tag);
            $this->assertIdenticalInputProps($entity1->DebitedFunds, $entity2->DebitedFunds);
            $this->assertIdenticalInputProps($entity1->CreditedFunds, $entity2->CreditedFunds);
            $this->assertIdenticalInputProps($entity1->Fees, $entity2->Fees);
            $this->assertIdentical($entity1->Status, $entity2->Status);

        } elseif (is_a($entity1, '\MangoPay\Money')) {
            $this->assertIdentical($entity1->Currency, $entity2->Currency);
            $this->assertIdentical($entity1->Amount, $entity2->Amount);
        } else {
            throw new \Exception("Unsupported type");
        }
    }
}
