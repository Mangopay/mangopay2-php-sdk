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

    public function test_RateLimitsDoc()
    {
        $this->assertNull($this->_api->RateLimits);
        $this->getJohnsCardPreAuthorization();

        $rateLimits = $this->_api->RateLimits;

        print "\nThere were " . $rateLimits[0]->CallsMade . " calls made in the last 15 minutes";
        print "\nYou can do " . $rateLimits[0]->CallsRemaining . " more calls in the next 15 minutes";
        print "\nThe 60 minutes counter will reset at " . date("Y-m-d\TH:i:s\Z", $rateLimits[0]->ResetTimeTimestamp);
        print "\nThere were " . $rateLimits[2]->CallsMade . " calls made in the last 60 minutes";
        print "\nYou can do " . $rateLimits[2]->CallsRemaining . " more calls in the next 60 minutes";
        print "\nThe 60 minutes counter will reset at " . date("Y-m-d\TH:i:s\Z", $rateLimits[2]->ResetTimeTimestamp);

        $this->assertNotNull($rateLimits);
    }
}
