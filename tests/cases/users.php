<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic CRUD methods for users
 */
class Users extends Base {

    function test_Users_CreateNatural() {
        $john = $this->getJohn();
        $this->assertTrue($john->Id > 0);
        $this->assertIdentical($john->PersonType, \MangoPay\PersonType::Natural);
    }

    function test_Users_CreateLegal() {
        $matrix = $this->getMatrix();
        $this->assertTrue($matrix->Id > 0);
        $this->assertIdentical($matrix->PersonType, \MangoPay\PersonType::Legal);
    }

    function test_Users_CreateLegal_FailsIfRequiredPropsNotProvided() {
        $user = new \MangoPay\UserLegal();
        $this->expectException();
        
        $ret = $this->_api->Users->Create($user);
        
        $this->fail("Creation should fail because required props are not set");
    }

    function test_Users_CreateLegal_PassesIfRequiredPropsProvided() {
        $user = new \MangoPay\UserLegal();
        $user->Name = "SomeOtherSampleOrg";
        $user->Email = "mail@test.com";
        $user->LegalPersonType = "BUSINESS";
        $user->LegalRepresentativeFirstName = "FirstName";
        $user->LegalRepresentativeLastName = "LastName";
        $user->LegalRepresentativeAddress = "Address";
        $user->LegalRepresentativeBirthday = mktime(0, 0, 0, 12, 21, 1975);
        $user->LegalRepresentativeNationality = "FR";
        $user->LegalRepresentativeCountryOfResidence = "FR";

        $ret = $this->_api->Users->Create($user);

        $this->assertTrue($ret->Id > 0, "Created successfully after required props set");
        $this->assertIdenticalInputProps($user, $ret);
    }

    function test_Users_GetNatural() {
        $john = $this->getJohn();

        $user1 = $this->_api->Users->Get($john->Id);
        $user2 = $this->_api->Users->GetNatural($john->Id);

        $this->assertIdentical($user1, $john);
        $this->assertIdentical($user2, $john);
        $this->assertIdenticalInputProps($user1, $john);
    }

    function test_Users_GetNatural_FailsForLegalUser() {
        $matrix = $this->getMatrix();
        $this->expectException();
        
        $user = $this->_api->Users->GetNatural($matrix->Id);
        
        $this->fail("GetNatural should fail when called with legal user id");
    }

    function test_Users_GetLegal_FailsForNaturalUser() {
        $john = $this->getJohn();
        $this->expectException();
        
        $user = $this->_api->Users->GetLegal($john->Id);
        
        $this->fail("GetLegal should fail when called with natural user id");
    }

    function test_Users_GetLegal() {
        $matrix = $this->getMatrix();

        $user1 = $this->_api->Users->Get($matrix->Id);
        $user2 = $this->_api->Users->GetLegal($matrix->Id);

        $this->assertIdentical($user1, $matrix);
        $this->assertIdentical($user2, $matrix);
        $this->assertIdenticalInputProps($user1, $matrix);
    }

    function test_Users_Save_Natural() {
        $john = $this->getJohn();
        $john->LastName .= " - CHANGED";
        
        $userSaved = $this->_api->Users->Update($john);
        $userFetched = $this->_api->Users->Get($john->Id);
        
        $this->assertIdenticalInputProps($userSaved, $john);
        $this->assertIdenticalInputProps($userFetched, $john);
    }

    function test_Users_Save_Legal() {
        $matrix = $this->getMatrix();
        $matrix->LegalRepresentativeLastName .= " - CHANGED";
        
        $userSaved = $this->_api->Users->Update($matrix);
        $userFetched = $this->_api->Users->Get($matrix->Id);
        
        $this->assertIdenticalInputProps($userSaved, $matrix);
        $this->assertIdenticalInputProps($userFetched, $matrix);
    }
    
    function test_Users_CreateBankAccount_IBAN() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        
        $this->assertTrue($account->Id > 0);
        $this->assertIdentical($account->UserId, $john->Id);
    }

    function test_Users_CreateBankAccount_GB() {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsGB();
        $account->Details->AccountNumber = '234234234234';
        $account->Details->SortCode = '234334';
        
        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);
        
        $this->assertTrue($createAccount->Id > 0);
        $this->assertIdentical($createAccount->UserId, $john->Id);
        $this->assertIdentical($createAccount->Type, 'GB');
        $this->assertIdentical($createAccount->Details->AccountNumber, '234234234234');
        $this->assertIdentical($createAccount->Details->SortCode, '234334');
    }
    
    function test_Users_CreateBankAccount_US() {
        $john = $this->getJohn();
        $account = new \MangoPay\BankAccount();
        $account->OwnerName = $john->FirstName . ' ' . $john->LastName;
        $account->OwnerAddress = $john->Address;
        $account->Details = new \MangoPay\BankAccountDetailsUS();
        $account->Details->AccountNumber = '234234234234';
        $account->Details->ABA = '234334789';
        
        $createAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);
        
        $this->assertTrue($createAccount->Id > 0);
        $this->assertIdentical($createAccount->UserId, $john->Id);
        $this->assertIdentical($createAccount->Type, 'US');
        $this->assertIdentical($createAccount->Details->AccountNumber, '234234234234');
        $this->assertIdentical($createAccount->Details->ABA, '234334789');
    }
    
    function test_Users_CreateBankAccount_CA() {
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
        $this->assertIdentical($createAccount->UserId, $john->Id);
        $this->assertIdentical($createAccount->Type, 'CA');
        $this->assertIdentical($createAccount->Details->AccountNumber, '234234234234');
        $this->assertIdentical($createAccount->Details->BankName, 'TestBankName');
        $this->assertIdentical($createAccount->Details->BranchCode, '12345');
        $this->assertIdentical($createAccount->Details->InstitutionNumber, '123');
    }
    
    function test_Users_CreateBankAccount_OTHER() {
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
        $this->assertIdentical($createAccount->UserId, $john->Id);
        $this->assertIdentical($createAccount->Type, 'OTHER');
        $this->assertIdentical($createAccount->Details->Type, 'OTHER');
        $this->assertIdentical($createAccount->Details->Country, 'FR');
        $this->assertIdentical($createAccount->Details->AccountNumber, '234234234234');
        $this->assertIdentical($createAccount->Details->BIC, 'BINAADADXXX');
    }
    
    function test_Users_BankAccount() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        
        $accountFetched = $this->_api->Users->GetBankAccount($john->Id, $account->Id);
        $this->assertIdenticalInputProps($account, $accountFetched);
    }
    
    function test_Users_BankAccounts() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination(1, 12);
        
        $list = $this->_api->Users->GetBankAccounts($john->Id, $pagination);
        
        $this->assertIsA($list[0], '\MangoPay\BankAccount');
        $this->assertIdentical($account->Id, $list[0]->Id);
        $this->assertIdenticalInputProps($account, $list[0]);
        $this->assertIdentical($pagination->Page, 1);
        $this->assertIdentical($pagination->ItemsPerPage, 12);
        $this->assertTrue(isset($pagination->TotalPages));
        $this->assertTrue(isset($pagination->TotalItems));
    }
    
    function test_Users_CreateKycDocument(){
        $kycDocument = $this->getJohnsKycDocument();
        
        $this->assertTrue($kycDocument->Id > 0);
        $this->assertIdentical($kycDocument->Status, \MangoPay\KycDocumentStatus::Created);
        $this->assertIdentical($kycDocument->Type, \MangoPay\KycDocumentType::IdentityProof);
    }
    
    function test_Users_GetKycDocument(){
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        
        $getKycDocument = $this->_api->Users->GetKycDocument($user->Id, $kycDocument->Id);
        
        $this->assertIdentical($kycDocument->Id, $getKycDocument->Id);
        $this->assertIdentical($kycDocument->Status, $getKycDocument->Status);
        $this->assertIdentical($kycDocument->Type, $getKycDocument->Type);
    }
    
    function test_Users_CreateKycDocument_TestAll(){
        $john = $this->getJohn();
        $legalJohn = $this->getMatrix();
        
        $aKycDocTypes = array(
            array(\MangoPay\KycDocumentType::AddressProof, $john->Id),
            array(\MangoPay\KycDocumentType::ArticlesOfAssociation, $legalJohn->Id),
            array(\MangoPay\KycDocumentType::IdentityProof, $john->Id),
            array(\MangoPay\KycDocumentType::RegistrationProof, $legalJohn->Id),
            array(\MangoPay\KycDocumentType::ShareholderDeclaration, $legalJohn->Id)
        );
        
        foreach ($aKycDocTypes as $kycDoc) {
            try{
                $this->CreateKycDocument_TestOne($kycDoc[0], $kycDoc[1]);
            } catch (\MangoPay\Exception $exc){
                
                $message = 'Error (Code: ' . $exc->getCode() . ', '
                    . $exc->getMessage() . ') '
                    .'during create/get KYC Document with type: ' . $kycDoc[0];
                $this->fail($message);
                
            }
        }
    }
    
    function CreateKycDocument_TestOne($kycDocType, $userId){
        
        $kycDocument = new \MangoPay\KycDocument();
        $kycDocument->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocument->Type = $kycDocType;
        
        $createdKycDocument = $this->_api->Users->CreateKycDocument($userId, $kycDocument);
        $getKycDocument = $this->_api->Users->GetKycDocument($userId, $createdKycDocument->Id);
        
        $this->assertTrue($createdKycDocument->Id > 0);
        $this->assertIdentical($createdKycDocument->Status, \MangoPay\KycDocumentStatus::Created);
        $this->assertIdentical($createdKycDocument->Type, $kycDocType);
        $this->assertIdentical($createdKycDocument->Id, $getKycDocument->Id);
        $this->assertIdentical($createdKycDocument->Status, $getKycDocument->Status);
        $this->assertIdentical($createdKycDocument->Type, $getKycDocument->Type);
    }
    
    function test_Users_UpdateKycDocument(){
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $kycDocument->Status = \MangoPay\KycDocumentStatus::ValidationAsked;
        
        $updateKycDocument = $this->_api->Users->UpdateKycDocument($user->Id, $kycDocument);
        
        $this->assertIdentical($updateKycDocument->Status, \MangoPay\KycDocumentStatus::ValidationAsked);
    }
    
    function test_Users_CreateKycPage_EmptyFileString(){
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = "";
        try{
            $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);
            
            $this->fail('Expected ResponseException when empty file string');
        } catch (\MangoPay\ResponseException $exc) {

            $this->assertIdentical($exc->getCode(), 500);            
        }
    }
    
    function test_Users_CreateKycPage_WrongFileString(){
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = "qqqq";
        
        try{
            $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);
            
            $this->fail('Expected ResponseException when wrong value for file string');
        } catch (\MangoPay\ResponseException $exc) {
            
            $this->assertIdentical($exc->getCode(), 500);            
        }
    }
    
    function test_Users_CreateKycPage_CorrectFileString() {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);
        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = "dGVzdCB0ZXN0IHRlc3QgdGVzdA==";
        
        $this->_api->Users->CreateKycPage($user->Id, $kycDocument->Id, $kycPage);
    }
    
    function test_Users_CreateKycPage_EmptyFilePath() {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);
        
        try{
            $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, '');
        } catch (\MangoPay\Exception $exc) {
            
            $this->assertIdentical($exc->getMessage(), 'Path of file cannot be empty');
        }
    }
        
    function test_Users_CreateKycPage_WrongFilePath() {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);
        
        try{
            $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, 'notExistFileName.tmp');
        } catch (\MangoPay\Exception $exc) {
            
            $this->assertIdentical($exc->getMessage(), 'File not exist');
        }
    }
    
    function test_Users_CreateKycPage_CorrectFilePath() {
        $user = $this->getJohn();
        $kycDocumentInit = new \MangoPay\KycDocument();
        $kycDocumentInit->Status = \MangoPay\KycDocumentStatus::Created;
        $kycDocumentInit->Type = \MangoPay\KycDocumentType::IdentityProof;
        $kycDocument = $this->_api->Users->CreateKycDocument($user->Id, $kycDocumentInit);
        
        $this->_api->Users->CreateKycPageFromFile($user->Id, $kycDocument->Id, __FILE__);
    }
    
    function test_Users_AllTransactions() {
        $john = $this->getJohn();
        $payIn = $this->getNewPayInCardDirect();

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';
        $filter->AfterDate = $payIn->CreationDate - 1;
        $filter->BeforeDate = $payIn->CreationDate + 1;
        $transactions = $this->_api->Users->GetTransactions($john->Id, $pagination, $filter);

        $this->assertEqual(count($transactions), 1);
        $this->assertIsA($transactions[0], '\MangoPay\Transaction');
        $this->assertEqual($transactions[0]->AuthorId, $john->Id);
        $this->assertIdenticalInputProps($transactions[0], $payIn);
    }
    
    function test_Users_AllCards() {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card =$this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination(1, 1);
        
        $cards = $this->_api->Users->GetCards($john->Id, $pagination);

        $this->assertEqual(count($cards), 1);
        $this->assertIsA($cards[0], '\MangoPay\Card');
        $this->assertIdenticalInputProps($cards[0], $card);
    }
}
