<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for pay-outs
 */
class PayOuts extends Base {
    
    function test_PayOuts_Create_BankWire() {
        $payOut = $this->getPayOutBankWire();
        
        $this->assertTrue($payOut->Id > 0);
        $this->assertIdentical($payOut, 'CARD');
        $this->assertIsA($payOut->MeanOfPayment, '\MangoPay\BankWirePayOut');
    }
    
    function test_PayOuts_Get_BankWire() {
        $payOut = $this->getPayOutBankWire();
        
        $getPayOut = $this->_api->PayOuts->Get($payOut->Id);
        
        $this->assertIdentical($payOut->Id, $getPayOut->Id);
        $this->assertIdentical($payOut->MeanOfPaymentType, 'BANK_WIRE');
        $this->assertIsA($payOut->MeanOfPayment, '\MangoPay\BankWirePayOut');
        $this->assertIdenticalInputProps($payOut, $getPayOut);
    }
}