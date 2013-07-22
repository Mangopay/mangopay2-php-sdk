<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic CRUD methods for users
 */
class Users extends Base {

    function testUsersCreateNatural() {
        $john = $this->getJohn();
        $this->assertTrue($john->Id > 0);
        $this->assertIdentical($john->PersonType, \MangoPay\PersonType::Natural);
    }

    function testUsersCreateLegal() {
        $matrix = $this->getMatrix();
        $this->assertTrue($matrix->Id > 0);
        $this->assertIdentical($matrix->PersonType, \MangoPay\PersonType::Legal);
    }

    function testUsersCreateLegalFailsIfRequiredPropsNotProvided() {
        $user = new \MangoPay\UserLegal();
        $this->expectException();
        $ret = $this->_api->Users->Create($user);
        $this->fail("Creation should fail because required props are not set");
    }

    function testUsersCreateLegalPassesIfRequiredPropsProvided() {
        $user = new \MangoPay\UserLegal();
        $user->Name = "SomeOtherSampleOrg";
        $user->LegalPersonType = "BUSINESS";
        $ret = $this->_api->Users->Create($user);
        $this->assertTrue($ret->Id > 0, "Created successfully after required props set");
        $this->assertIdenticalInputProps($user, $ret);
    }

    function testUsersGetNatural() {
        $john = $this->getJohn();

        $user1 = $this->_api->Users->Get($john->Id);
        $user2 = $this->_api->Users->GetNatural($john->Id);

        $this->assertIdentical($user1, $john);
        $this->assertIdentical($user2, $john);
        $this->assertIdenticalInputProps($user1, $john);
    }

    function testUsersGetNaturalFailsForLegalUser() {
        $matrix = $this->getMatrix();
        $this->expectException();
        $user = $this->_api->Users->GetNatural($matrix->Id);
        $this->fail("GetNatural should fail when called with legal user id");
    }

    function testUsersGetLegalFailsForNaturalUser() {
        $john = $this->getJohn();
        $this->expectException();
        $user = $this->_api->Users->GetLegal($john->Id);
        $this->fail("GetLegal should fail when called with natural user id");
    }

    function testUsersGetLegal() {
        $matrix = $this->getMatrix();

        $user1 = $this->_api->Users->Get($matrix->Id);
        $user2 = $this->_api->Users->GetLegal($matrix->Id);

        $this->assertIdentical($user1, $matrix);
        $this->assertIdentical($user2, $matrix);
        $this->assertIdenticalInputProps($user1, $matrix);
    }

    function testUsersSaveNatural() {
        $john = $this->getJohn();
        $john->LastName .= " - CHANGED";
        $userSaved = $this->_api->Users->Save($john);
        $userFetched = $this->_api->Users->Get($john->Id);
        $this->assertIdenticalInputProps($userSaved, $john);
        $this->assertIdenticalInputProps($userFetched, $john);
    }

    function testUsersSaveLegal() {
        $matrix = $this->getMatrix();
        $matrix->LegalRepresentativeLastName .= " - CHANGED";
        $userSaved = $this->_api->Users->Save($matrix);
        $userFetched = $this->_api->Users->Get($matrix->Id);
        $this->assertIdenticalInputProps($userSaved, $matrix);
        $this->assertIdenticalInputProps($userFetched, $matrix);
    }
}
