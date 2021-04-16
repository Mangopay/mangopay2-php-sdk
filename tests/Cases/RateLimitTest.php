<?php

namespace MangoPay\Tests\Cases;

class RateLimitTest extends Base
{
    public function test_RateLimitsUpdate()
    {
        $this->assertNull($this->_api->RateLimits);
        $this->getJohnsCardPreAuthorization();

        $rateLimits = $this->_api->RateLimits;

        $this->assertNotNull($rateLimits);
        $this->assertTrue(sizeof($rateLimits) == 4);
    }
}
