<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for pay-ins
 */
class PayIns extends Base {
    
    function test_PayIns_Create_CardWeb() {
        $payIn = $this->getJohnsPayInCardWeb();

        $this->assertTrue($payIn->Id > 0);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
    }
    
    function test_PayIns_Get_CardWeb() {
        $payIn = $this->getJohnsPayInCardWeb();
        
        $getPayIn = $this->_api->PayIns->Get($payIn->Id);
        
        $this->assertIdentical($payIn->Id, $getPayIn->Id);
        $this->assertIdentical($payIn->PaymentType, 'CARD');
        $this->assertIsA($payIn->PaymentDetails, '\MangoPay\PayInPaymentDetailsCard');
        $this->assertIdentical($payIn->ExecutionType, 'WEB');
        $this->assertIsA($payIn->ExecutionDetails, '\MangoPay\PayInExecutionDetailsWeb');
        $this->assertIdenticalInputProps($payIn, $getPayIn);
        $this->assertIdentical($getPayIn->Status, 'CREATED');
        $this->assertNull($getPayIn->ExecutionDate);
        $this->assertNotNull($getPayIn->ExecutionDetails->RedirectURL);
        $this->assertNotNull($getPayIn->ExecutionDetails->ReturnURL);
    }
}