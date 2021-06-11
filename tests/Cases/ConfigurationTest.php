<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\ResponseException;

/**
 * Tests for holding authentication token in instance
 */
class ConfigurationTest extends Base
{
    public function test_confInConstruct()
    {
        $this->_api->Config->ClientId = "test_asd";
        $this->_api->Config->ClientPassword = "00000";

        $this->expectException(ResponseException::class);
        $this->_api->Users->GetAll();
    }
}
