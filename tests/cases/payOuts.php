<?php
namespace MangoPay\Tests;

require_once 'base.php';

/**
 * Tests methods for pay-outs
 */
class PayOuts extends Base {

    function test_PayOut_Create(){
        $payOut = $this->getJohnsPayOutForCardDirect();
        
        $this->assertTrue($payOut->Id > 0);
        $this->assertIdentical($payOut->PaymentType, \MangoPay\PayOutPaymentType::BankWire);
        $this->assertIsA($payOut->MeanOfPaymentDetails, '\MangoPay\PayOutPaymentDetailsBankWire');
    }
    
    function test_PayOut_Get(){
        $payOut = $this->getJohnsPayOutForCardDirect();
        
        $payOutGet = $this->_api->PayOuts->Get($payOut->Id);
        
        $this->assertIdentical($payOut->Id, $payOutGet->Id);
        $this->assertIdentical($payOut->PaymentType, $payOutGet->PaymentType);
        $this->assertIdentical($payOutGet->Status, \MangoPay\PayOutStatus::Created);
        $this->assertIdenticalInputProps($payOut, $payOutGet);
        $this->assertNull($payOutGet->ExecutionDate);
    }
    
    // Cannot test anything else here: have no pay-ins with sufficient status?
    function test_PayOuts_Create_BankWire_FailsCauseNotEnoughMoney() {
        $payOut = $this->getJohnsPayOutBankWire();
        
        $this->assertIdentical(\MangoPay\PayOutStatus::Failed, $payOut->Status);
    }
}

