<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BusinessType;
use MangoPay\Money;
use MangoPay\PayIn;
use MangoPay\PayInExecutionDetailsDirect;
use MangoPay\PayInPaymentDetailsBankWire;
use MangoPay\PayInStatus;
use MangoPay\PayOut;
use MangoPay\PayOutPaymentDetailsBankWire;
use MangoPay\Sector;
use MangoPay\Sorting;

/**
 * Test class for Client API
 */
class ClientTest extends Base
{
    public function test_Clients_Get()
    {
        $getClients = $this->_api->Clients->Get();

        $this->assertEquals($this->_api->Config->ClientId, $getClients->ClientId);
        $this->assertNotNull($getClients->Licensor);
    }

    public function test_Clients_Save()
    {
        $phoneNumber = (string)rand(0, 99999999);

        $clients = new \MangoPay\Client();
        $clients->PrimaryButtonColour = "#afafae";
        $clients->PrimaryThemeColour = "#afafae";
        $clients->PlatformDescription = "platform description";
        $clients->PlatformCategorization = new \MangoPay\PlatformCategorization();
        $clients->PlatformCategorization->BusinessType = BusinessType::MARKETPLACE;
        $clients->PlatformCategorization->Sector = Sector::FURNITURE_GARDEN;
        $clients->PlatformURL = "http://sdk-unit-tests.com";
        $clients->HeadquartersAddress = new \MangoPay\Address();
        $clients->HeadquartersAddress->AddressLine1 = "AddressLine1";
        $clients->HeadquartersAddress->AddressLine2 = "AddressLine2";
        $clients->HeadquartersAddress->City = "City";
        $clients->HeadquartersAddress->Region = "Region";
        $clients->HeadquartersAddress->PostalCode = "11222";
        $clients->HeadquartersAddress->Country = "FR";
        $clients->HeadquartersPhoneNumber = $phoneNumber;
        $clients->TaxNumber = "12345";
        $clients->TechEmails = ["technical@mangopay.com", "support@mangopay.com"];
        $clients->AdminEmails = ["technical@mangopay.com", "support@mangopay.com"];
        $clients->FraudEmails = ["technical@mangopay.com", "support@mangopay.com"];
        $clients->BillingEmails = ["technical@mangopay.com", "support@mangopay.com"];

        $saveClients = $this->_api->Clients->Update($clients);

        $this->assertEquals($this->_api->Config->ClientId, $saveClients->ClientId);
        $this->assertSame($clients->HeadquartersPhoneNumber, $saveClients->HeadquartersPhoneNumber);
    }

    public function test_Clients_UploadLogo_EmptyFileString()
    {
        $logo = new \MangoPay\ClientLogoUpload();
        $logo->File = "";
        try {
            $this->_api->Clients->UploadLogo($logo);

            $this->fail('Expected ResponseException when empty file string');
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            $this->assertFalse($exc->getCode() == 204);
        }
    }

    public function test_Clients_UploadLogo_WrongFileString()
    {
        $logo = new \MangoPay\ClientLogoUpload();
        $logo->File = "qqqq";

        try {
            $this->_api->Clients->UploadLogo($logo);

            $this->fail('Expected ResponseException when wrong value for file string');
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            $this->assertFalse($exc->getCode() == 204);
        }
    }

    public function test_Clients_UploadLogo_CorrectFileString()
    {
        $this->markTestSkipped("skipped");
        $logo = new \MangoPay\ClientLogoUpload();
        $logo->File = "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";

        $this->_api->Clients->UploadLogo($logo);
        $this->assertTrue(true);
    }

    public function test_Clients_UploadLogoFromFile_EmptyFilePath()
    {
        try {
            $this->_api->Clients->UploadLogoFromFile('');

            $this->fail('Expected ResponseException when wrong value for path of file');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('Path of file cannot be empty', $exc->getMessage());
        }
    }

    public function test_Clients_UploadLogoFromFile_WrongFilePath()
    {
        try {
            $this->_api->Clients->UploadLogoFromFile('notExistFileName.tmp');

            $this->fail('Expected ResponseException when wrong value for path of file');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('File not exist', $exc->getMessage());
        }
    }

    public function test_Clients_UploadLogoFromFile_CorrectFilePath()
    {
        $this->markTestSkipped("skipped");
        $this->_api->Clients->UploadLogoFromFile(__DIR__ . "/../TestKycPageFile.png");
        $this->assertTrue(true);
    }

    public function test_GetWallets_WrongFundsTypeValue()
    {
        try {
            $this->_api->Clients->GetWallets("WrongValue");

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertInstanceOf('MangoPay\Libraries\Exception', $exc);
        }
    }

    public function test_GetWallets_FundsTypeAll()
    {
        $sorting = new Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::ASC);
        $wallets = $this->_api->Clients->GetWallets(null, $sorting);

        $this->assertTrue(count($wallets) > 0);
        $this->assertInstanceOf('\MangoPay\Wallet', $wallets[0]);
    }

    public function test_GetWallets_FundsTypeFees()
    {
        $wallets = $this->_api->Clients->GetWallets(\MangoPay\FundsType::FEES);

        $this->assertTrue(count($wallets) > 0);
        $this->assertInstanceOf('\MangoPay\Wallet', $wallets[0]);
    }

    public function test_GetWallets_FundsTypeCredit()
    {
        $wallets = $this->_api->Clients->GetWallets(\MangoPay\FundsType::CREDIT);

        $this->assertTrue(count($wallets) > 0);
        $this->assertInstanceOf('\MangoPay\Wallet', $wallets[0]);
    }

    public function test_GetWallet_FirstParameterNull()
    {
        try {
            $this->_api->Clients->GetWallet(null, null);

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('First parameter in function GetWallet in class ApiClients is required.', $exc->getMessage());
        }
    }

    public function test_GetWallet_FirstParameterWrongValue()
    {
        try {
            $this->_api->Clients->GetWallet("WrongValue", \MangoPay\CurrencyIso::EUR);

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertInstanceOf('\MangoPay\Libraries\Exception', $exc);
        }
    }

    public function test_GetWallet_SecondParameterNull()
    {
        try {
            $this->_api->Clients->GetWallet(\MangoPay\FundsType::FEES, null);

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('Second parameter in function GetWallet in class ApiClients is required.', $exc->getMessage());
        }
    }

    public function test_GetWallet_FundsTypeFees()
    {
        $wallet = $this->_api->Clients->GetWallet(\MangoPay\FundsType::FEES, \MangoPay\CurrencyIso::EUR);

        $this->assertInstanceOf('\MangoPay\Wallet', $wallet);
        $this->assertEquals(\MangoPay\CurrencyIso::EUR, $wallet->Currency);
    }

    public function test_GetWallet_FundsTypeCredit()
    {
        $wallet = $this->_api->Clients->GetWallet(\MangoPay\FundsType::CREDIT, \MangoPay\CurrencyIso::EUR);

        $this->assertInstanceOf('\MangoPay\Wallet', $wallet);
        $this->assertEquals(\MangoPay\CurrencyIso::EUR, $wallet->Currency);
    }

    public function test_GetWalletTransactions_WrongFundsTypeValue()
    {
        try {
            $this->_api->Clients->GetWalletTransactions("WrongValue", null);

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('\MangoPay\FundsType object has wrong value.', $exc->getMessage());
        }
    }

    public function test_GetWalletTransactions_SecondParameterNull()
    {
        try {
            $this->_api->Clients->GetWalletTransactions(\MangoPay\FundsType::FEES, null);

            $this->fail('Expected ResponseException when wrong value for FundsType');
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('If FundsType is defined the second parameter (currency) is required.', $exc->getMessage());
        }
    }

    public function test_GetWalletTransactions_All()
    {
        $this->markTestSkipped("Endpoint removed");
        $transactions = $this->_api->Clients->GetWalletTransactions();

        $this->assertTrue(count($transactions) > 0);
        $this->assertInstanceOf('\MangoPay\Transaction', $transactions[0]);
    }

    public function test_GetWalletTransactions_Fees()
    {
        $transactions = $this->_api->Clients->GetWalletTransactions(\MangoPay\FundsType::FEES, \MangoPay\CurrencyIso::EUR);

        $this->assertTrue(count($transactions) > 0);
        $this->assertInstanceOf('\MangoPay\Transaction', $transactions[0]);
    }

    public function test_CreateBankAccount()
    {
        $account = $this->getClientBankAccount();

        $createdAccount = $this->_api->Clients->CreateBankAccount($account);

        $this->assertNotNull($createdAccount);
        $this->assertNotNull($createdAccount->Id);
    }

    public function test_CreatePayOut()
    {
        $account = $this->getClientBankAccount();
        $createdAccount = $this->_api->Clients->CreateBankAccount($account);

        $wallets = $this->_api->Clients->GetWallets(\MangoPay\FundsType::FEES);
        $payOut = new PayOut();

        $payOut->Tag = 'bla';
        $payOut->DebitedFunds = new Money();
        $payOut->DebitedFunds->Currency = 'EUR';
        $payOut->DebitedFunds->Amount = 12;

        $payOut->DebitedWalletId = $wallets[0]->Id;
        $payOut->MeanOfPaymentDetails = new PayOutPaymentDetailsBankWire();
        $payOut->MeanOfPaymentDetails->BankAccountId = $createdAccount->Id;
        $payOut->MeanOfPaymentDetails->BankWireRef = 'invoice 7282';
        $payOut->MeanOfPaymentDetails->PayoutModeRequested = 'STANDARD';

        $createdPayOut = $this->_api->Clients->CreatePayOut($payOut);
        print_r($createdPayOut);

        $this->assertNotNull($createdPayOut);
        $this->assertNotNull($createdPayOut->Id);
    }

    public function test_CreateBankWireDirectPayIn()
    {
        $payIn = new PayIn();
        $payIn->CreditedWalletId = "CREDIT_EUR";
        $payIn->PaymentDetails = new PayInPaymentDetailsBankWire();
        $payIn->PaymentDetails->DeclaredDebitedFunds = new Money();
        $payIn->PaymentDetails->DeclaredDebitedFunds->Amount = 100;
        $payIn->PaymentDetails->DeclaredDebitedFunds->Currency = 'EUR';
        $payIn->ExecutionDetails = new PayInExecutionDetailsDirect();

        $createPayIn = $this->_api->Clients->CreateBankWireDirectPayIn($payIn);

        $this->assertNotNull($createPayIn->Id);
        $this->assertEquals(\MangoPay\PayInPaymentType::BankWire, $createPayIn->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayInPaymentDetailsBankWire', $createPayIn->PaymentDetails);
        $this->assertInstanceOf('\MangoPay\Money', $createPayIn->PaymentDetails->DeclaredDebitedFunds);
        $this->assertEquals(\MangoPay\PayInExecutionType::Direct, $createPayIn->ExecutionType);
        $this->assertInstanceOf('\MangoPay\PayInExecutionDetailsDirect', $createPayIn->ExecutionDetails);
        $this->assertEquals(PayInStatus::Created, $createPayIn->Status);
        $this->assertEquals('PAYIN', $createPayIn->Type);
    }
}
