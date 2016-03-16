<?php

namespace MangoPay\Tests;

require_once 'base.php';

/**
 * Tests basic methods for transfers
 */
class Transfers extends Base {

    function test_Transfers_Create() {
        $john = $this->getJohn();

        $transfer = $this->getNewTransfer();
        $creditedWallet = $this->_api->Wallets->Get($transfer->CreditedWalletId);

        $this->assertTrue($transfer->Id > 0);
        $this->assertEqual($transfer->AuthorId, $john->Id);
        $this->assertEqual($transfer->CreditedUserId, $john->Id);
        $this->assertEqual(100, $creditedWallet->Balance->Amount);
    }

    function test_Transfers_Get() {
        $john = $this->getJohn();
        $transfer = $this->getNewTransfer();

        $getTransfer = $this->_api->Transfers->Get($transfer->Id);

        $this->assertIdentical($transfer->Id, $getTransfer->Id);
        $this->assertEqual($getTransfer->AuthorId, $john->Id);
        $this->assertEqual($getTransfer->CreditedUserId, $john->Id);
        $this->assertIdenticalInputProps($transfer, $getTransfer);
    }

    public function test_Transfers_CreateRefund() {
        $transfer = $this->getNewTransfer();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);
                
        $refund = $this->getNewRefundForTransfer($transfer);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertTrue($refund->Id > 0);
        $this->assertTrue($refund->DebitedFunds->Amount, $transfer->DebitedFunds->Amount);
        $this->assertEqual($walletBefore->Balance->Amount, $walletAfter->Balance->Amount - $transfer->DebitedFunds->Amount);
        $this->assertEqual('TRANSFER', $refund->Type);
        $this->assertEqual('REFUND', $refund->Nature);
        $this->assertIsA($refund->RefundReason, '\MangoPay\RefundReasonDetails');
    }
}