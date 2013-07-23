<?php
namespace MangoPay\Tests;

/**
 * Tests methods for pay-ins
 */
class PayIns extends Base {
    
    function test_PayIns_Create_CardWeb() {
        $payIn = $this->getPayInCardWeb();
        
        $this->assertTrue($payIn->Id > 0);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->Payment, '\MangoPay\Card');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->Execution, '\MangoPay\Web');
    }
    
    function test_PayIns_Get_CardWeb() {
        $payIn = $this->getPayInCardWeb();
        
        $getPayIn = $this->_api->PayIns->Get($payIn->Id);
        
        $this->assertIdentical($payIn->Id, $getPayIn->Id);
         $this->assertIdentical($getPayIn->PaymentType, 'CARD');
        $this->assertIsA($getPayIn->Payment, '\MangoPay\Card');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($getPayIn->Execution, '\MangoPay\Web');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertNotNull($getPayIn->Status);
        $this->assertNotNull($getPayIn->ExecutionDate);
    }
}