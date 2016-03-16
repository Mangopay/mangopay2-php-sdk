<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for refunds
 */
class Refunds extends Base {
    
    public function test_Refund_GetForTransfer() {
        $transfer = $this->getNewTransfer();
        $refund = $this->getNewRefundForTransfer($transfer);
        $user = $this->getJohn();
        
        $getRefund = $this->_api->Refunds->Get($refund->Id);
        
        $this->assertEqual($getRefund->Id, $refund->Id);
        $this->assertEqual($getRefund->InitialTransactionId, $transfer->Id);
        $this->assertEqual($getRefund->AuthorId, $user->Id);
        $this->assertEqual($getRefund->Type, 'TRANSFER');
        $this->assertIsA($getRefund->RefundReason, '\MangoPay\RefundReasonDetails');
    }
    
    public function test_Refund_GetForPayIn() {
        $payIn = $this->getNewPayInCardDirect();
        $refund = $this->getNewRefundForPayIn($payIn);
        $user = $this->getJohn();

        $getRefund = $this->_api->Refunds->Get($refund->Id);
        
        $this->assertEqual($getRefund->Id, $refund->Id);
        $this->assertEqual($getRefund->InitialTransactionId, $payIn->Id);
        $this->assertEqual($getRefund->AuthorId, $user->Id);
        $this->assertEqual($getRefund->Type, 'PAYOUT');
        $this->assertIsA($getRefund->RefundReason, '\MangoPay\RefundReasonDetails');
    }
}
