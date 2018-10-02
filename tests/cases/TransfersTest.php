<?php

namespace MangoPay\Tests\Cases;


/**
 * Tests basic methods for transfers
 */
class TransfersTest extends Base
{

    function test_Transfers_Create()
    {
        $john = $this->getJohn();

        $transfer = $this->getNewTransfer();
        $creditedWallet = $this->_api->Wallets->Get($transfer->CreditedWalletId);

        $this->assertTrue($transfer->Id > 0);
        $this->assertEquals($john->Id, $transfer->AuthorId);
        $this->assertEquals($john->Id, $transfer->CreditedUserId);
        $this->assertEquals(100, $creditedWallet->Balance->Amount);
    }

    function test_Transfers_Get()
    {
        $john = $this->getJohn();
        $transfer = $this->getNewTransfer();

        $getTransfer = $this->_api->Transfers->Get($transfer->Id);

        $this->assertSame($transfer->Id, $getTransfer->Id);
        $this->assertEquals($john->Id, $getTransfer->AuthorId);
        $this->assertEquals($john->Id, $getTransfer->CreditedUserId);
        $this->assertIdenticalInputProps($transfer, $getTransfer);
    }

    public function test_Transfers_CreateRefund()
    {
        $transfer = $this->getNewTransfer();
        $wallet = $this->getJohnsWalletWithMoney();
        $walletBefore = $this->_api->Wallets->Get($wallet->Id);

        $refund = $this->getNewRefundForTransfer($transfer);
        $walletAfter = $this->_api->Wallets->Get($wallet->Id);

        $this->assertTrue($refund->Id > 0);
        $this->assertSame($refund->DebitedFunds->Amount, $transfer->DebitedFunds->Amount);
        $this->assertEquals($walletBefore->Balance->Amount, $walletAfter->Balance->Amount - $transfer->DebitedFunds->Amount);
        $this->assertEquals('TRANSFER', $refund->Type);
        $this->assertEquals('REFUND', $refund->Nature);
        $this->assertInstanceOf('\MangoPay\RefundReasonDetails', $refund->RefundReason);
    }

    public function test_Transfer_GetRefunds()
    {
        $transfer = $this->getNewTransfer();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->Transfers->GetRefunds($transfer->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertInternalType('array', $refunds);
    }
}