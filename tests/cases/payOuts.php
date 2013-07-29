<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for pay-outs
 */
class PayOuts extends Base {
    
    // Cannot test: Bad request. The amount you wish to spend must be smaller than the amount left in your collection
    function test_PayOuts_Create_BankWire() {
        try {
            $payIn = $this->getJohnsPayInCardWeb();
            $payOut = $this->getJohnsPayOutBankWire();
            $this->fail('Should throw ResponseException');

            $this->assertTrue($payOut->Id > 0);
            $this->assertIdentical($payOut->MeanOfPaymentType, 'BANK_WIRE');
            $this->assertIsA($payOut->MeanOfPaymentDetails, '\MangoPay\PayOutPaymentDetailsBankWire');
        }
        catch (\MangoPay\ResponseException $ex) {
            $this->assertIdentical($ex->getCode(), 400);
            $this->assertTrue(strpos($ex->getMessage(), 'The amount you wish to spend must be smaller than the amount left in your collection') !== false);
        }
        catch (\Exception $ex) {
            $this->fail('Should throw ResponseException');
        }
    }
    
    // Cannot test: Bad request. The amount you wish to spend must be smaller than the amount left in your collection
//    function test_PayOuts_Get_BankWire() {
//        $payOut = $this->getJohnsPayOutBankWire();
//        
//        $getPayOut = $this->_api->PayOuts->Get($payOut->Id);
//        
//        $this->assertIdentical($payOut->Id, $getPayOut->Id);
//        $this->assertIdentical($payOut->MeanOfPaymentType, 'BANK_WIRE');
//        $this->assertIsA($payOut->MeanOfPaymentDetails, '\MangoPay\PayOutPaymentDetailsBankWire');
//        $this->assertIdenticalInputProps($payOut, $getPayOut);
//    }
}