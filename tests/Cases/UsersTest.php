<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\Exception;
use MangoPay\Libraries\Logs;
use MangoPay\Libraries\ResponseException;

/**
 * Tests basic CRUD methods for users
 */
class UsersTest extends Base
{
    public function test_Users_CreateNatural()
    {
        $john = $this->getJohn();
        $this->assertTrue($john->Id > 0);
        $this->assertSame(\MangoPay\PersonType::Natural, $john->PersonType);
    }

    public function test_Users_CreateLegal()
    {
        $matrix = $this->getMatrix();
        $this->assertTrue($matrix->Id > 0);
        $this->assertSame(\MangoPay\PersonType::Legal, $matrix->PersonType);
    }

    public function test_Users_GetEMoney()
    {
        $john = $this->getJohn();
        $year = 2019;
        $month = 4;
        $ret = $this->_api->Users->GetEMoney($john->Id, $year, null);
        $this->assertSame($john->Id, $ret->UserId);

        $ret = $this->_api->Users->GetEMoney($john->Id, $year, $month);
        $this->assertSame($john->Id, $ret->UserId);
    }

    public function test_Users_GetEMoneyFunctionWithOneParam()
    {
        $john = $this->getJohn();
        $ret = $this->_api->Users->GetEMoney($john->Id);
        $this->assertSame($john->Id, $ret->UserId);
    }

    public function test_Users_GetEMoneyWithNullValues()
    {
        $john = $this->getJohn();
        $ret = $this->_api->Users->GetEMoney($john->Id, null, null);
        $this->assertSame($john->Id, $ret->UserId);
    }

    /**
     * @throws Exception
     */
    public function test_Users_CreateLegal_FailsIfRequiredPropsNotProvided()
    {
        $user = new \MangoPay\UserLegal();
        $this->expectException(ResponseException::class);

        $ret = $this->_api->Users->Create($user);

        $this->fail("Creation should fail because required props are not set");
    }

    public function test_Users_CreateLegal_PassesIfRequiredPropsProvided()
    {
        $user = new \MangoPay\UserLegal();
        $user->HeadquartersAddress = new \MangoPay\Address();
        $user->HeadquartersAddress->AddressLine1 = 'AddressLine1';
        $user->HeadquartersAddress->AddressLine2 = 'AddressLine2';
        $user->HeadquartersAddress->City = 'City';
        $user->HeadquartersAddress->Country = 'FR';
        $user->HeadquartersAddress->PostalCode = '11222';
        $user->HeadquartersAddress->Region = 'Region';
        $user->Name = "SomeOtherSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = \MangoPay\LegalPersonType::Business;
        $user->LegalRepresentativeFirstName = "FirstName";
        $user->LegalRepresentativeLastName = "LastName";
        $user->LegalRepresentativeAddress = new \MangoPay\Address();
        $user->LegalRepresentativeAddress->AddressLine1 = 'AddressLine1';
        $user->LegalRepresentativeAddress->AddressLine2 = 'AddressLine2';
        $user->LegalRepresentativeAddress->City = 'City';
        $user->LegalRepresentativeAddress->Country = 'FR';
        $user->LegalRepresentativeAddress->PostalCode = '11222';
        $user->LegalRepresentativeAddress->Region = 'Region';
        $user->LegalRepresentativeBirthday = mktime(0, 0, 0, 12, 21, 1975);
        $user->LegalRepresentativeNationality = "FR";
        $user->LegalRepresentativeCountryOfResidence = "FR";
        $user->CompanyNumber = "LU12345678";

        $ret = $this->_api->Users->Create($user);

        $this->assertTrue($ret->Id > 0, "Created successfully after required props set");
        $this->assertIdenticalInputProps($user, $ret);
    }

    public function test_Users_GetNatural()
    {
        $john = $this->getJohn();

        $user1 = $this->_api->Users->Get($john->Id);
        $user2 = $this->_api->Users->GetNatural($john->Id);

        $this->assertEquals($user1, $john);
        $this->assertEquals($user2, $john);
        $this->assertIdenticalInputProps($user1, $john);
    }

    public function test_Users_GetNatural_FailsForLegalUser()
    {
        $matrix = $this->getMatrix();
        $this->expectException(ResponseException::class);

        $user = $this->_api->Users->GetNatural($matrix->Id);

        $this->fail("GetNatural should fail when called with legal user id");
    }

    public function test_Users_GetLegal_FailsForNaturalUser()
    {
        $john = $this->getJohn();
        $this->expectException(ResponseException::class);

        $user = $this->_api->Users->GetLegal($john->Id);

        $this->fail("GetLegal should fail when called with natural user id");
    }

    public function test_Users_GetLegal()
    {
        $matrix = $this->getMatrix();

        $user1 = $this->_api->Users->Get($matrix->Id);
        $user2 = $this->_api->Users->GetLegal($matrix->Id);

        $this->assertEquals($matrix, $user1);
        $this->assertEquals($matrix, $user2);
        $this->assertIdenticalInputProps($user1, $matrix);
    }

    public function test_Users_Save_Natural()
    {
        $john = $this->getJohn();
        $john->LastName .= " - CHANGED";

        $userSaved = $this->_api->Users->Update($john);
        $userFetched = $this->_api->Users->Get($john->Id);

        $this->assertIdenticalInputProps($userSaved, $john);
        $this->assertIdenticalInputProps($userFetched, $john);
    }

    public function test_Users_Save_NaturalAndClearAddresIfNeeded()
    {
        $user = new \MangoPay\UserNatural();
        $user->FirstName = "John";
        $user->LastName = "Doe";
        $user->Email = "john.doe@sample.org";
        $user->Birthday = mktime(0, 0, 0, 12, 21, 1975);
        $user->Nationality = "FR";
        $user->CountryOfResidence = "FR";
        $newUser = $this->_api->Users->Create($user);

        $userSaved = $this->_api->Users->Update($newUser);

        $this->assertTrue($userSaved->Id > 0);
    }

    public function test_Users_Save_Legal()
    {
        $matrix = $this->getMatrix();
        $matrix->LegalRepresentativeLastName .= " - CHANGED";

        $userSaved = $this->_api->Users->Update($matrix);
        $userFetched = $this->_api->Users->Get($matrix->Id);

        $this->assertIdenticalInputProps($userSaved, $matrix);
        $this->assertIdenticalInputProps($userFetched, $matrix);
    }

    public function test_Users_Save_LegalAndClearAddresIfNeeded()
    {
        $user = new \MangoPay\UserLegal();
        $user->Name = "MartixSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = \MangoPay\LegalPersonType::Business;
        $user->LegalRepresentativeFirstName = "FirstName";
        $user->LegalRepresentativeLastName = "LastName";
        $user->LegalRepresentativeBirthday = mktime(0, 0, 0, 12, 21, 1975);
        $user->LegalRepresentativeNationality = "FR";
        $user->LegalRepresentativeCountryOfResidence = "FR";
        $newUser = $this->_api->Users->Create($user);

        $userSaved = $this->_api->Users->Update($newUser);

        $this->assertTrue($userSaved->Id > 0);
    }

    public function test_Users_CreateBankAccount_IBAN()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();

        $this->assertTrue($account->Id > 0);
        $this->assertSame($john->Id, $account->UserId);
    }

    public function test_Users_CreateBankAccount_GB()
    {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsGB();
        $account->Details->AccountNumber = '63956474';
        $account->Details->SortCode = '200000';

        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);

        $this->assertTrue($createAccount->Id > 0);
        $this->assertSame($john->Id, $createAccount->UserId);
        $this->assertSame('GB', $createAccount->Type);
        $this->assertSame('63956474', $createAccount->Details->AccountNumber);
        $this->assertSame('200000', $createAccount->Details->SortCode);
    }

    public function test_Users_CreateBankAccount_US()
    {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsUS();
        $account->Details->AccountNumber = '234234234234';
        $account->Details->ABA = '234334789';

        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);

        $this->assertTrue($createAccount->Id > 0);
        $this->assertSame($john->Id, $createAccount->UserId);
        $this->assertSame('US', $createAccount->Type);
        $this->assertSame('234234234234', $createAccount->Details->AccountNumber);
        $this->assertSame('234334789', $createAccount->Details->ABA);
    }

    public function test_Users_CreateBankAccount_CA()
    {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsCA();
        $account->Details->BankName = 'TestBankName';
        $account->Details->BranchCode = '12345';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->InstitutionNumber = '123';

        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);

        $this->assertTrue($createAccount->Id > 0);
        $this->assertSame($john->Id, $createAccount->UserId);
        $this->assertSame('CA', $createAccount->Type);
        $this->assertSame('234234234234', $createAccount->Details->AccountNumber);
        $this->assertSame('TestBankName', $createAccount->Details->BankName);
        $this->assertSame('12345', $createAccount->Details->BranchCode);
        $this->assertSame('123', $createAccount->Details->InstitutionNumber);
    }

    public function test_Users_CreateBankAccount_OTHER()
    {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsOTHER();
        $account->Details->Type = 'OTHER';
        $account->Details->Country = 'FR';
        $account->Details->AccountNumber = '234234234234';
        $account->Details->BIC = 'BINAADADXXX';

        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);

        $this->assertTrue($createAccount->Id > 0);
        $this->assertSame($john->Id, $createAccount->UserId);
        $this->assertSame('OTHER', $createAccount->Type);
        $this->assertSame('OTHER', $createAccount->Details->Type);
        $this->assertSame('FR', $createAccount->Details->Country);
        $this->assertSame('234234234234', $createAccount->Details->AccountNumber);
        $this->assertSame('BINAADADXXX', $createAccount->Details->BIC);
    }

    public function test_Users_DeactivateBankAccount()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $account->Active = false;

        $account = $this->_api->Users->UpdateBankAccount($john->Id, $account);

        $this->assertFalse($account->Active);
    }

    public function test_Users_BankAccount()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();

        $accountFetched = $this->_api->Users->GetBankAccount($john->Id, $account->Id);
        $this->assertIdenticalInputProps($account, $accountFetched);
    }

    public function test_Users_BankAccounts()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination(1, 12);

        $list = $this->_api->Users->GetBankAccounts($john->Id, $pagination);

        $this->assertInstanceOf('\MangoPay\BankAccount', $list[0]);
        $this->assertSame($list[sizeof($list) - 1]->Id, $account->Id);
        $this->assertIdenticalInputProps($account, $list[sizeof($list) - 1]);
        $this->assertSame(1, $pagination->Page);
        $this->assertSame(12, $pagination->ItemsPerPage);
        $this->assertTrue(isset($pagination->TotalPages));
        $this->assertTrue(isset($pagination->TotalItems));
    }

    public function test_Users_BankAccounts_SortByCreationDate()
    {
        $john = $this->getJohn();
        $this->getJohnsAccount();
        self::$JohnsAccount = null;
        $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination(1, 12);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $list = $this->_api->Users->GetBankAccounts($john->Id, $pagination, $sorting);

        $this->assertTrue($list[0]->CreationDate >= $list[1]->CreationDate);
    }

    public function test_Users_BankAccounts_Filtering()
    {
        $john = $this->getJohn();
        $this->getJohnsAccount();
        self::$JohnsAccount = null;
        $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination(1, 12);
        $filter = new \MangoPay\FilterBankAccounts();
        $filter->Active = 'false';

        $inactiveList = $this->_api->Users->GetBankAccounts($john->Id, $pagination, null, $filter);
        $this->assertCount(1, $inactiveList);

        $filter = new \MangoPay\FilterBankAccounts();
        $filter->Active = 'true';

        $activeList = $this->_api->Users->GetBankAccounts($john->Id, $pagination, null, $filter);
        $this->assertCount(12, $activeList);
    }

    public function test_Users_UpdateBankAccount()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $account->Active = false;

        $accountResult = $this->_api->Users->UpdateBankAccount($john->Id, $account);

        $this->assertSame($account->Id, $accountResult->Id);
        $this->assertFalse($accountResult->Active);
    }

    public function test_Users_CreateKycDocument()
    {
        $kycDocument = $this->getJohnsKycDocument();

        $user = $this->getJohn();
        $this->assertTrue($kycDocument->Id > 0);
        $this->assertSame(\MangoPay\KycDocumentStatus::Created, $kycDocument->Status);
        $this->assertSame(\MangoPay\KycDocumentType::IdentityProof, $kycDocument->Type);
        $this->assertSame($kycDocument->UserId, $user->Id);
    }

    public function test_Users_GetKycDocument()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();

        $getKycDocument = $this->_api->Users->GetKycDocument($user->Id, $kycDocument->Id);

        $this->assertSame($kycDocument->Id, $getKycDocument->Id);
        $this->assertSame($kycDocument->Status, $getKycDocument->Status);
        $this->assertSame($kycDocument->Type, $getKycDocument->Type);
        $this->assertSame($kycDocument->UserId, $user->Id);
    }

    public function test_Users_GetKycDocuments()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $pagination = new \MangoPay\Pagination(1, 20);

        $getKycDocuments = $this->_api->Users->GetKycDocuments($user->Id, $pagination);

        $this->assertInstanceOf('\MangoPay\KycDocument', $getKycDocuments[0]);
        $kycFromList = $this->getEntityFromList($kycDocument->Id, $getKycDocuments);
        $this->assertSame($kycDocument->Id, $kycFromList->Id);
        $this->assertIdenticalInputProps($kycDocument, $kycFromList);
        $this->assertSame($pagination->Page, 1);
        $this->assertSame($pagination->ItemsPerPage, 20);
        $this->assertTrue(isset($pagination->TotalPages));
        $this->assertTrue(isset($pagination->TotalItems));
    }

    public function test_Users_GetKycDocuments_SortByCreationDate()
    {
        $this->getJohnsKycDocument();
        self::$JohnsKycDocument = null;
        $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $pagination = new \MangoPay\Pagination(1, 20);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $getKycDocuments = $this->_api->Users->GetKycDocuments($user->Id, $pagination, $sorting);

        $this->assertTrue($getKycDocuments[0]->CreationDate >= $getKycDocuments[1]->CreationDate);
    }

    public function test_Users_CreateKycDocument_TestAll()
    {
        $john = $this->getJohn();
        $legalJohn = $this->getMatrix();

        $aKycDocTypes = [
            [\MangoPay\KycDocumentType::AddressProof, $john->Id],
            [\MangoPay\KycDocumentType::ArticlesOfAssociation, $legalJohn->Id],
            [\MangoPay\KycDocumentType::IdentityProof, $john->Id],
            [\MangoPay\KycDocumentType::RegistrationProof, $legalJohn->Id],
            [\MangoPay\KycDocumentType::ShareholderDeclaration, $legalJohn->Id]
        ];

        foreach ($aKycDocTypes as $kycDoc) {
            try {
                $this->CreateKycDocument_TestOne($kycDoc[0], $kycDoc[1]);
            } catch (\MangoPay\Libraries\Exception $exc) {
                $message = 'Error (Code: ' . $exc->getCode() . ', '
                    . $exc->getMessage() . ') '
                    . 'during create/get KYC Document with type: ' . $kycDoc[0];
                $this->fail($message);
            }
        }
    }

    public function CreateKycDocument_TestOne($kycDocType, $userId)
    {
        $kycDocument = new \MangoPay\KycDocument();
        $kycDocument->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocument->Type = $kycDocType;

        $createdKycDocument = $this->_api->Users->CreateKycDocument($userId, $kycDocument);
        $getKycDocument = $this->_api->Users->GetKycDocument($userId, $createdKycDocument->Id);

        $this->assertTrue($createdKycDocument->Id > 0);
        $this->assertSame(\MangoPay\KycDocumentStatus::Created, $createdKycDocument->Status);
        $this->assertSame($kycDocType, $createdKycDocument->Type);
        $this->assertSame($getKycDocument->Id, $createdKycDocument->Id);
        $this->assertSame($getKycDocument->Status, $createdKycDocument->Status);
        $this->assertSame($getKycDocument->Type, $createdKycDocument->Type);
    }

    public function test_Users_UpdateKycDocument()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();

        $success = $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, __DIR__ . "/../TestKycPageFile.png");

        $kycDocument->Status = \MangoPay\KycDocumentStatus::ValidationAsked;

        $updateKycDocument = $this->_api->Users->UpdateKycDocument($user->Id, $kycDocument);

        $this->assertSame(\MangoPay\KycDocumentStatus::ValidationAsked, $updateKycDocument->Status);
        $this->assertTrue($success);
    }

    public function test_Users_CreateKycPage_EmptyFileString()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = "";
        $uploaded = null;
        try {
            $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);

            $this->fail('Expected ResponseException when empty file string');
        } catch (ResponseException $exc) {
            $this->assertSame(400, $exc->getCode());
        }
    }

    public function test_Users_CreateKycPage_WrongFileString()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = "qqqq";

        try {
            $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);

            $this->fail('Expected ResponseException when wrong value for file string');
        } catch (ResponseException $exc) {
            $this->assertSame(400, $exc->getCode());
        }
    }

    public function test_Users_CreateKycPage_CorrectFileString()
    {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);
        $kycPage = new \MangoPay\KycPage();
        $fileString = base64_encode(file_get_contents(__DIR__ . '/../TestKycPageFile.png'));
        $kycPage->File = $fileString;

        $uploaded = $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);
        $this->assertTrue($uploaded);
    }

    public function test_Users_CreateKycPage_EmptyFilePath()
    {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);

        try {
            $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, '');
            $this->fail("This should have failed because path to file is empty");
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('Path of file cannot be empty', $exc->getMessage());
        }
    }

    public function test_Users_CreateKycPage_WrongFilePath()
    {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);

        try {
            $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, 'notExistFileName.tmp');
            $this->fail("This should have failed because file is non existent");
        } catch (\MangoPay\Libraries\Exception $exc) {
            $this->assertSame('File not exist', $exc->getMessage());
        }
    }

    public function test_Users_CreateKycPage_CorrectFilePath()
    {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);

        $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, __DIR__ . "/../TestKycPageFile.png");
        $this->assertTrue(true);
    }

    public function test_Users_AllTransactions()
    {
        $john = $this->getJohn();
        $payIn = $this->getNewPayInCardDirect();

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';
        $filter->AfterDate = $payIn->CreationDate - 1;
        $filter->BeforeDate = $payIn->CreationDate + 1;
        $transactions = $this->_api->Users->GetTransactions($john->Id, $pagination, $filter);

        $this->assertEquals(1, count($transactions));
        $this->assertInstanceOf('\MangoPay\Transaction', $transactions[0]);
        $this->assertEquals($john->Id, $transactions[0]->AuthorId);
        $this->assertIdenticalInputProps($transactions[0], $payIn);
    }

    public function test_Users_AllTransactions_SortByCreationDate()
    {
        $john = $this->getJohn();
        $this->getNewPayInCardDirect();
        $this->getNewPayInCardDirect();
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);
        $pagination = new \MangoPay\Pagination(1, 20);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';

        $transactions = $this->_api->Users->GetTransactions($john->Id, $pagination, $filter, $sorting);

        $this->assertTrue($transactions[0]->CreationDate >= $transactions[1]->CreationDate);
    }

    public function test_Users_AllCards()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination(1, 1);

        $cards = $this->_api->Users->GetCards($john->Id, $pagination);

        $this->assertEquals(1, count($cards));
        $this->assertInstanceOf('\MangoPay\Card', $cards[0]);
        $this->assertIdenticalInputProps($cards[0], $card);
    }

    public function test_Users_AllCards_SortByCreationDate()
    {
        $john = $this->getNewJohn();
        $this->getNewPayInCardDirect($john->Id);
        $this->getNewPayInCardDirect($john->Id);
        $pagination = new \MangoPay\Pagination(1, 20);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::ASC);

        $cards = $this->_api->Users->GetCards($john->Id, $pagination, $sorting);

        $this->assertTrue($cards[0]->CreationDate < $cards[1]->CreationDate);
    }

    public function test_Users_AllWallets()
    {
        $john = $this->getJohn();
        $this->getJohnsWallet();
        $pagination = new \MangoPay\Pagination(1, 1);

        $wallets = $this->_api->Users->GetWallets($john->Id, $pagination);

        $this->assertEquals(1, count($wallets));
        $this->assertInstanceOf('\MangoPay\Wallet', $wallets[0]);
    }

    public function test_Users_AllWallets_SortByCreationDate()
    {
        $john = $this->getJohn();
        $this->getJohnsWallet();
        self::$JohnsWallet = null;
        $this->getJohnsWallet();
        $pagination = new \MangoPay\Pagination(1, 20);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $wallets = $this->_api->Users->GetWallets($john->Id, $pagination, $sorting);

        $this->assertTrue($wallets[0]->CreationDate >= $wallets[1]->CreationDate);
    }

    public function test_Users_AllMandates()
    {
        $john = $this->getJohn();
        $this->getJohnsMandate();
        $pagination = new \MangoPay\Pagination(1, 1);

        $mandates = $this->_api->Users->GetMandates($john->Id, $pagination);

        $this->assertEquals(1, count($mandates));
        $this->assertInstanceOf('\MangoPay\Mandate', $mandates[0]);
    }

    public function test_Users_AllMandatesForBankAccount()
    {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $this->getJohnsMandate();
        $pagination = new \MangoPay\Pagination(1, 1);

        $mandates = $this->_api->Users->GetMandatesForBankAccount($john->Id, $account->Id, $pagination);

        $this->assertEquals(1, count($mandates));
        $this->assertInstanceOf('\MangoPay\Mandate', $mandates[0]);
    }

    public function test_Users_GetPreAuthorizations()
    {
        $john = $this->getJohn();

        $preauthorizations = $this->_api->Users->GetPreAuthorizations($john->Id);

        $this->assertNotNull($preauthorizations);
        $this->assertTrue(is_array($preauthorizations), 'Expected an array');
    }

    public function test_395()
    {
        try {
            /*
            $this->_api->Config->ClientId = 'wd786';
            $this->_api->Config->ClientPassword = 'my_api_key';
            $this->_api->Config->TemporaryFolder = 'temp/xxx/';
            $this->_api->Config->BaseUrl = 'https://api.sandbox.mangopay.com'; */
            // CREATE NATURAL USER
            $naturalUser = new \MangoPay\UserNatural();
            $naturalUser->Email = 'test_natural_user@testmangopay.com';
            $naturalUser->FirstName = "Bob";
            $naturalUser->LastName = "Briant";
            $naturalUser->Birthday = 121271;
            $naturalUser->Nationality = "FR";
            $naturalUser->CountryOfResidence = "ZA";
            $naturalUserResult = $this->_api->Users->Create($naturalUser); // display result
            Logs::Debug('CREATED NATURAL USER', $naturalUserResult);
            // CREATE LEGAL USER
            $legalUser = new \MangoPay\UserLegal();
            $legalUser->Name = 'Name Legal Test';
            $legalUser->LegalPersonType = 'BUSINESS';
            $legalUser->Email = 'legal@testmangopay.com';
            $legalUser->LegalRepresentativeFirstName = "Bob";
            $legalUser->LegalRepresentativeLastName = "Briant";
            $legalUser->LegalRepresentativeBirthday = 121271;
            $legalUser->LegalRepresentativeNationality = "FR";
            $legalUser->LegalRepresentativeCountryOfResidence = "ZA";
            $legalUserResult = $this->_api->Users->Create($legalUser);
            // display result
            Logs::Debug('CREATED LEGAL USER', $legalUserResult);

            $this->assertEquals($naturalUserResult->Email, $naturalUser->Email);
        } catch (ResponseException $e) {
            Logs::Debug('MangoPay\ResponseException Code', $e->GetCode());
            Logs::Debug('Message', $e->GetMessage());
            Logs::Debug('Details', $e->GetErrorDetails());
        } catch (\MangoPay\Libraries\Exception $e) {
            Logs::Debug('MangoPay\Exception Message', $e->GetMessage());
        }
    }

    public function test_get_user_block_regulatory()
    {
        $user = $this->getJohn();
        $regulatory = $this->_api->Users->GetRegulatory($user->Id);

        $this->assertNotNull($regulatory);
    }

    public function test_user_natural_terms_and_conditions()
    {
        $user = $this->getJohn();
        $this->assertFalse($user->TermsAndConditionsAccepted);

        $user->TermsAndConditionsAccepted = true;
        $updatedUser = $this->_api->Users->Update($user);
        $this->assertTrue($updatedUser->TermsAndConditionsAccepted);
        $this->assertNotNull($updatedUser->TermsAndConditionsAcceptedDate);

        $accepted = $this->getJohnWithTermsAccepted();
        $this->assertTrue($accepted->TermsAndConditionsAccepted);
        $this->assertNotNull($accepted->TermsAndConditionsAcceptedDate);
    }
}
