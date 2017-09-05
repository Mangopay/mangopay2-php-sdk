<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests API methods for the UBO declaration entity.
 */
class UboDeclarations extends Base {

    function test_UboDeclarations_Get() {
        $declaration = $this->getCreatedUboDeclaration();
        $declaration = $this->_api->UboDeclarations->Get($declaration->Id);

        $this->assertNotNull($declaration);
    }

    function test_UboDeclarations_Update() {
        $declaration = $this->getCreatedUboDeclaration();
        $declaration->Status = \MangoPay\UboDeclarationStatus::ValidationAsked;
        $declaration = $this->_api->UboDeclarations->Update($declaration);

        $this->assertNotNull($declaration);
        $this->assertEqual($declaration->Status, \MangoPay\UboDeclarationStatus::ValidationAsked);
    }
}