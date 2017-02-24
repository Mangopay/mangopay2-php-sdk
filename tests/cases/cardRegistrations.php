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
        $this->assertEqual(\MangoPay\CardRegistrationStatus::Created, $cardRegistration->Status);
    }
    
    function test_CardRegistrations_Get() {
        $cardRegistration = $this->getJohnsCardRegistration();

        $getCardRegistration = $this->_api->CardRegistrations->Get($cardRegistration->Id);
        
        $this->assertTrue($getCardRegistration->Id > 0);
        $this->assertEqual($cardRegistration->Id, $getCardRegistration->Id);
    }
    
    function test_CardRegistrations_Update() {
        $cardRegistration = $this->getJohnsCardRegistration();
        $registrationData = $this->getPaylineCorrectRegistartionData($cardRegistration);
        $cardRegistration->RegistrationData = $registrationData;
        
        $getCardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

        $this->assertEqual($registrationData, $getCardRegistration->RegistrationData);
        $this->assertNotNull($getCardRegistration->CardId);
        $this->assertIdentical(\MangoPay\CardRegistrationStatus::Validated, $getCardRegistration->Status);
        $this->assertIdentical('000000', $getCardRegistration->ResultCode);
    }
    
    function test_CardRegistrations_UpdateError() {
        $user = $this->getJohn();
        $cardRegistrationNew = new \MangoPay\CardRegistration();
        $cardRegistrationNew->UserId = $user->Id;
        $cardRegistrationNew->Currency = 'EUR';
        $cardRegistration = $this->_api->CardRegistrations->Create($cardRegistrationNew);
        $cardRegistration->RegistrationData = "Wrong-data";
        
        $getCardRegistration = $this->_api->CardRegistrations->Update($cardRegistration);

        $this->assertEqual(\MangoPay\CardRegistrationStatus::Error, $getCardRegistration->Status);
        $this->assertNotNull($getCardRegistration->ResultCode);
        $this->assertNotNull($getCardRegistration->ResultMessage);
    }
    
    function test_Cards_CheckCardExisting() {
        $cardRegistration = $this->getJohnsCardRegistration();
        $cardRegistration = $this->_api->CardRegistrations->Get($cardRegistration->Id);
        
        $card = $this->_api->Cards->Get($cardRegistration->CardId);
        
        $this->assertTrue($card->Id > 0);
        $this->assertEqual($card->Validity, \MangoPay\CardValidity::Unknown);
    }
    
    function test_Cards_Update(){
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $card = $this->_api->Cards->Get($cardPreAuthorization->CardId);
        $cardToUpdate = new \MangoPay\Card();
        $cardToUpdate->Id = $card->Id;
        $cardToUpdate->Validity = \MangoPay\CardValidity::Invalid;
                       
        $updatedCard = $this->_api->Cards->Update($cardToUpdate);
        
        $this->assertEqual($card->Validity, \MangoPay\CardValidity::Valid);
        $this->assertEqual($updatedCard->Validity, \MangoPay\CardValidity::Valid);
        $this->assertFalse($updatedCard->Active);
    }

}
