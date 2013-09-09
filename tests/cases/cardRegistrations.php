<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for card registrations
 */
class CardRegistrations extends Base {
    
    function test_CardRegistrations_Create() {
        $cardRegistration = $this->getJohnsCardRegistration();
        $user = $this->getJohn();
        
        $this->assertTrue($cardRegistration->Id > 0);
        $this->assertNotNull($cardRegistration->AccessKey);
        $this->assertNotNull($cardRegistration->PreregistrationData);
        $this->assertNotNull($cardRegistration->CardRegistrationURL);
        $this->assertEqual($user->Id, $cardRegistration->UserId);
        $this->assertEqual('EUR', $cardRegistration->Currency);
        $this->assertEqual('CREATED', $cardRegistration->Status);
    }
    
    function test_CardRegistrations_Get() {
        $cardRegistration = $this->getJohnsCardRegistration();

        $getCardRegistration = $this->_api->CardRegistrations->Get($cardRegistration->Id);
        
        $this->assertTrue($getCardRegistration->Id > 0);
        $this->assertEqual($cardRegistration->Id, $getCardRegistration->Id);
    }
    
    function test_CardRegistrations_Update() {
        $cardRegistration = $this->getJohnsCardRegistration();
        $cardRegistration->RegistrationData = 'test RegistrationData';

        $getCardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);
        
        $this->assertEqual('test RegistrationData', $getCardRegistration->RegistrationData);
    }
}