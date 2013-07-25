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
        $user->LegalPersonType = "BUSINESS";
        $ret = $this->_api->Users->Create($user);
        $this->assertTrue($ret->Id > 0, "Created successfully after required props set");
        $this->assertIdenticalInputProps($user, $ret);
    }

    function tes_tUsers_GetNatural() {
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
        $userSaved = $this->_api->Users->Save($john);
        $userFetched = $this->_api->Users->Get($john->Id);
        $this->assertIdenticalInputProps($userSaved, $john);
        $this->assertIdenticalInputProps($userFetched, $john);
    }

    function test_Users_Save_Legal() {
        $matrix = $this->getMatrix();
        $matrix->LegalRepresentativeLastName .= " - CHANGED";
        $userSaved = $this->_api->Users->Save($matrix);
        $userFetched = $this->_api->Users->Get($matrix->Id);
        $this->assertIdenticalInputProps($userSaved, $matrix);
        $this->assertIdenticalInputProps($userFetched, $matrix);
    }
    
    function test_Users_CreateBankAccount() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $this->assertTrue($account->Id > 0);
        $this->assertIdentical($account->UserId, $john->Id);
    }

    function test_Users_GetBankAccount() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $accountFetched = $this->_api->Users->GetBankAccount($john->Id, $account->Id);
        $this->assertIdenticalInputProps($account, $accountFetched);
    }
    
    function test_Users_BankAccounts() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $pagiantion = new \MangoPay\Pagination(1, 12);
        
        $list = $this->_api->Users->BankAccounts($john->Id, $pagiantion);
        
        $this->assertIsA($list[0], '\MangoPay\BankAccount');
        $this->assertIdentical($account->Id, $list[0]->Id);
        $this->assertIdenticalInputProps($account, $list[0]);
        $this->assertIdentical($pagiantion->Page, 1);
        $this->assertIdentical($pagiantion->ItemsPerPage, 12);
        $this->assertTrue(isset($pagiantion->TotalPages));
        $this->assertTrue(isset($pagiantion->TotalItems));
    }
}
