<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for wallets
 */
class Hooks extends Base {
    
    function test_Hooks_Create() {
        $hook = $this->getJohnHook();
        
        $this->assertTrue($hook->Id > 0);
    }
    
    function test_Hooks_Get() {
        $hook = $this->getJohnHook();
        
        $getHook = $this->_api->Hooks->Get($hook->Id);
        
        $this->assertIdentical($getHook->Id, $hook->Id);
    }
    
    function test_Hooks_Update() {
        $hook = $this->getJohnHook();
        $hook->Url = "http://test123.com";
        
        $saveHook = $this->_api->Hooks->Update($hook);
        
        $this->assertIdentical($saveHook->Id, $hook->Id);
        $this->assertIdentical($saveHook->Url, "http://test123.com");
    }
    
    function test_Hooks_All() {
        $hook = $this->getJohnHook();
        $pagination = new \MangoPay\Pagination(1, 1);
        
        $list = $this->_api->Hooks->GetAll($pagination);
        
        $this->assertIsA($list[0], '\MangoPay\Hook');
        $this->assertIdentical($hook->Id, $list[0]->Id);
        $this->assertIdentical($pagination->Page, 1);
        $this->assertIdentical($pagination->ItemsPerPage, 1);
    }
}