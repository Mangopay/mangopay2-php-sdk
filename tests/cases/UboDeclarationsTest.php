<?php

namespace MangoPay\Tests\Cases;


/**
 * Tests API methods for the UBO declaration entity.
 */
class UboDeclarationsTest extends Base
{

    function test_UboDeclarations_Get()
    {
        $declaration = $this->getCreatedUboDeclaration();
        $declaration = $this->_api->UboDeclarations->Get($declaration->Id);

        $this->assertNotNull($declaration);
    }

    function test_UboDeclarations_Update()
    {
        $declaration = $this->getCreatedUboDeclaration();
        $declaration->Status = \MangoPay\UboDeclarationStatus::ValidationAsked;
        $declaration = $this->_api->UboDeclarations->Update($declaration);

        $this->assertNotNull($declaration);
        $this->assertEquals(\MangoPay\UboDeclarationStatus::ValidationAsked, $declaration->Status);
    }
}