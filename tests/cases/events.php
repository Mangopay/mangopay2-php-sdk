<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for events
 */
class Events extends Base {
    
    function test_GetEventList_PayinNormalCreated() {
        $payIn = $this->getJohnsPayInCardWeb();
        $filter = new \MangoPay\FilterEvents();
        $filter->BeforeDate = $payIn->CreationDate;
        $filter->AfterDate = $payIn->CreationDate;
        $filter->EventType = \MangoPay\EventType::PayinNormalCreated;
        $pagination = new \MangoPay\Pagination();

        $result = $this->_api->Events->GetAll($pagination, $filter);

        $this->assertTrue(count($result) > 0);
        $this->assertTrue($this->ExistEventById($result, $payIn->Id));        
    }
    
    function test_GetEventList_PayinNormalSucceeded() {
        $payIn = $this->getNewPayInCardDirect();
        $filter = new \MangoPay\FilterEvents();
        $filter->BeforeDate = $payIn->ExecutionDate;
        $filter->AfterDate = $payIn->ExecutionDate;
        $filter->EventType = \MangoPay\EventType::PayinNormalSucceeded;
        $pagination = new \MangoPay\Pagination();

        $result = $this->_api->Events->GetAll($pagination, $filter);

        $this->assertTrue(count($result) > 0);
        $this->assertTrue($this->ExistEventById($result, $payIn->Id));        
    }
    
    function test_GetEventList_PayoutNormalCreated() {
        $payOut = $this->getJohnsPayOutBankWire();
        $filter = new \MangoPay\FilterEvents();
        $filter->BeforeDate = $payOut->CreationDate;
        $filter->AfterDate = $payOut->CreationDate;
        $filter->EventType = \MangoPay\EventType::PayoutNormalCreated;
        $pagination = new \MangoPay\Pagination();

        $result = $this->_api->Events->GetAll($pagination, $filter);

        $this->assertTrue(count($result) > 0);
        $this->assertTrue($this->ExistEventById($result, $payOut->Id));        
    }
    
    /*function test_GetEventList_TransferNormalCreated() {
        $transfer = $this->getNewTransfer();
        $filter = new \MangoPay\FilterEvents();
        $filter->BeforeDate = $transfer->CreationDate;
        $filter->AfterDate = $transfer->CreationDate;
        $filter->EventType = \MangoPay\EventType::TransferNormalCreated;
        $pagination = new \MangoPay\Pagination();

        $result = $this->_api->Events->GetAll($pagination, $filter);

        $this->assertTrue(count($result) > 0);
        $this->assertTrue($this->ExistEventById($result, $transfer->Id));        
    }*/
    
    private function ExistEventById($eventList, $eventId) {
        
        foreach ($eventList as $event) {
            if ($event->RessourceId == $eventId) {
                return true;
            }
        }
        
        return false;
    }
}