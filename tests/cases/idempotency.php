<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for idempotency support
 * See https://docs.mangopay.com/api-references/idempotency-support/
 */
class Idempotency extends Base {

 	// if post request called twice with no idempotency key, act independently
    function test_NoIdempotencyKey_ActIndependently() {
		$user = $this->buildJohn();
		$user1 = $this->_api->Users->Create($user);
		$user2 = $this->_api->Users->Create($user);
        $this->assertTrue($user2->Id > $user1->Id);
    }

	// if post request called twice with same idempotency key, 2nd call is blocked
    function test_SameIdempotencyKey_Blocks2ndCall() {
		$idempotencyKey = md5(uniqid());
		$user = $this->buildJohn();
		$user1 = $this->_api->Users->Create($user);
		$user1 = $this->_api->Users->Create($user, $idempotencyKey);
        $this->expectException('MangoPay\Libraries\ResponseException');
		$user2 = $this->_api->Users->Create($user, $idempotencyKey);
        $this->assertTrue($user2 = null);
	}

	// if post request called twice with different idempotency key, act independently and responses may be retreived later
    function test_DifferentIdempotencyKey_ActIndependentlyAndRetreivable() {
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
    
    function test_IdempotencyKey_CheckResponseObject() {
        $idempotencyKey = md5(uniqid());
        $user = $this->buildJohn();
        $user1 = $this->_api->Users->Create($user, $idempotencyKey);

        // responses may be retreived later
        $resp1 = $this->_api->Responses->Get($idempotencyKey);
	
        $this->assertIsA($resp1->Resource, '\MangoPay\UserNatural');
    }
}