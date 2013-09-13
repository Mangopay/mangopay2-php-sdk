<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for refunds
 */
class Refunds extends Base {
    
    public function test_Refund_GetForTransfer() {
        $refund = $this->getJohnsRefundForTransfer();
        $transfer = $this->getJohnsTransfer();
        $user = $this->getJohn();
        
        $getRefund = $this->_api->Refunds->Get($refund->Id);
        
        $this->assertEqual($getRefund->Id, $refund->Id);
        $this->assertEqual($getRefund->InitialTransactionId, $transfer->Id);
        $this->assertEqual($getRefund->AuthorId, $user->Id);
        $this->assertEqual($getRefund->Type, 'TRANSFER');
    }
    
    public function test_Refund_GetForPayIn() {
        /*$refund = $this->getJohnsRefundForPayIn();
        $payIn = $this->getJohnsPayInCardDirect();
        $user = $this->getJohn();

        $getRefund = $this->_api->Refunds->Get($refund->Id);
        
        $this->assertEqual($getRefund->Id, $refund->Id);
        $this->assertEqual($getRefund->InitialTransactionId, $payIn->Id);
        $this->assertEqual($getRefund->AuthorId, $user->Id);
        $this->assertEqual($getRefund->Type, 'PAYOUT');*/
    }
}
