<?php
namespace MangoPay\Tests;

require_once 'base.php';

/**
 * Tests methods for pay-ins
 */
class CardPreAuthorizations extends Base {

    function test_CardPreAuthorization_Create() {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        
        $this->assertTrue($cardPreAuthorization->Id > 0);
        $this->assertIdentical($cardPreAuthorization->Status, 'SUCCEEDED');
        $this->assertIdentical($cardPreAuthorization->PaymentStatus, 'WAITING');
        $this->assertIdentical($cardPreAuthorization->ExecutionType, 'DIRECT');
        $this->assertNull($cardPreAuthorization->PayInId);
    }
    
    function test_CardPreAuthorization_Get() {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        
        $getCardPreAuthorization = $this->_api->CardPreAuthorizations->Get($cardPreAuthorization->Id);
        
        $this->assertIdentical($cardPreAuthorization->Id, $getCardPreAuthorization->Id);
        $this->assertIdentical($getCardPreAuthorization->ResultCode, '000000');
    }
    
    function test_CardPreAuthorization_Update() {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $cardPreAuthorization->PaymentStatus = "CANCELED ";
        
        $resultCardPreAuthorization = $this->_api->CardPreAuthorizations->Update($cardPreAuthorization);
        
        $this->assertIdentical($resultCardPreAuthorization->Status, "SUCCEEDED");
        $this->assertIdentical($resultCardPreAuthorization->PaymentStatus, 'CANCELED');
    }
}