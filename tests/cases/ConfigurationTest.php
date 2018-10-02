<?php

namespace MangoPay\Tests\Cases;
use MangoPay\Libraries\ResponseException;


/**
 * Tests for holding authentication token in instance
 */
class ConfigurationTest extends Base
{
    /**
     * @expectedException MangoPay\Libraries\ResponseException
     */
    function test_confInConstruct()
    {
        $this->_api->Config->ClientId = "test_asd";
        $this->_api->Config->ClientPassword = "00000";

//        $this->excpectException('MangoPay\Libraries\ResponseException');
        $this->_api->Users->GetAll();
    }
}
