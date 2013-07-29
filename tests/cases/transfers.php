<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for transfers
 */
class Transfers extends Base {
     
    function test_Transfers_Create() {
        $john = $this->getJohn();
        $transfer = $this->getJohnsTransfer();
        
        $this->assertTrue($transfer->Id > 0);
        $this->assertEqual($transfer->AuthorId, $john->Id);
        $this->assertEqual($transfer->CreditedUserId, $john->Id);
    }
    
    function test_Transfers_Get() {
        $john = $this->getJohn();
        $transfer = $this->getJohnsTransfer();
        
        $getTransfer = $this->_api->Transfers->Get($transfer->Id);
        
        $this->assertIdentical($transfer->Id, $getTransfer->Id);
        $this->assertEqual($getTransfer->AuthorId, $john->Id);
        $this->assertEqual($getTransfer->CreditedUserId, $john->Id);
        $this->assertIdenticalInputProps($transfer, $getTransfer);
    }
}