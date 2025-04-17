<?php

namespace Cases;

use MangoPay\IdentityVerification;
use MangoPay\Tests\Cases\Base;

/**
 * Tests basic methods for IdentityVerifications
 */
class IdentityVerificationTest extends Base
{
    public static $identityVerification;

    public function test_IdentityVerification_Create()
    {
        $identityVerification = $this->getNewIdentityVerification();
        self::assertNotNull($identityVerification);
        self::assertNotNull($identityVerification->HostedUrl);
        self::assertNotNull($identityVerification->ReturnUrl);
        self::assertEquals('PENDING', $identityVerification->Status);
    }

    public function test_IdentityVerification_Get()
    {
        $identityVerification = $this->getNewIdentityVerification();
        $fetched = $this->_api->IdentityVerifications->Get($identityVerification->Id);

        self::assertNotNull($fetched);
        self::assertEquals($identityVerification->HostedUrl, $fetched->HostedUrl);
        self::assertEquals($identityVerification->ReturnUrl, $fetched->ReturnUrl);
        self::assertEquals($identityVerification->Status, $fetched->Status);
    }

    public function test_IdentityVerification_Get_Checks()
    {
        $this->markTestSkipped("endpoint returning 404");
        $identityVerification = $this->getNewIdentityVerification();
        $checks = $this->_api->IdentityVerifications->GetChecks($identityVerification->Id);

        self::assertNotNull($checks);
        self::assertEquals($identityVerification->Id, $checks->SessionId);
        self::assertEquals('PENDING', $checks->Status);
        self::assertTrue($checks->CreationDate > 0);
        self::assertTrue($checks->LastUpdate > 0);
        self::assertNotNull($checks->Checks);
    }

    private function getNewIdentityVerification()
    {
        if (self::$identityVerification == null) {
            $john = $this->getJohn();
            $identityVerificationCreate = new IdentityVerification();
            $identityVerificationCreate->ReturnUrl = "https://example.com";
            $identityVerificationCreate->Tag = "Created by the PHP SDK";
            self::$identityVerification = $this->_api->IdentityVerifications->Create($identityVerificationCreate, $john->Id);
        }
        return self::$identityVerification;
    }
}
