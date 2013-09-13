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
        $creditedWallet = $this->_api->Wallets->Get($transfer->CreditedWalletId);
        
        $this->assertTrue($transfer->Id > 0);
        $this->assertEqual($transfer->AuthorId, $john->Id);
        $this->assertEqual($transfer->CreditedUserId, $john->Id);
        $this->assertEqual(100, $creditedWallet->Balance->Amount);
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
    
    public function test_Transfers_CreateRefund() {
        $wallet = $this->getJohnsWallet();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);
        $transfer = $this->getJohnsTransfer();
                
        $refund = $this->getJohnsRefundForTransfer();
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertTrue($refund->Id > 0);
        $this->assertTrue($refund->DebitedFunds->Amount, $transfer->DebitedFunds->Amount);
        $this->assertEqual($walletBefore->Balance->Amount, $walletAfter->Balance->Amount - $transfer->DebitedFunds->Amount);
        $this->assertEqual('TRANSFER', $refund->Type);
        $this->assertEqual('REFUND', $refund->Nature);
    }
}