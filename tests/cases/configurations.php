<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests for holding authentication token in instance
 */
class Configurations extends Base {

    function test_confInConstruct() {
        $this->_api->Config->ClientId = "test_asd";
        $this->_api->Config->ClientPassword = "00000";        
        
        $this->expectException('MangoPay\Libraries\ResponseException');
        $this->_api->Users->GetAll();
     }
}
