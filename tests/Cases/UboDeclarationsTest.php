<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\Exception;
use MangoPay\Libraries\ResponseException;
use MangoPay\UboDeclarationStatus;

/**
 * Tests API methods for the UBO declaration entity.
 */
class UboDeclarationsTest extends Base
{
    public function test_CreateUboDeclaration()
    {
        $declaration = $this->getMatrixUboDeclaration();
        $this->assertNotNull($declaration);
        $this->assertEquals(UboDeclarationStatus::Created, $declaration->Status);
        $this->assertNotNull($declaration->Id);
    }

    public function test_ListUboDeclarations()
    {
        $declaration = $this->getMatrixUboDeclaration();
        $matrix = $this->getMatrix();

        $declarations = $this->_api->UboDeclarations->GetAll($matrix->Id);

        $this->assertNotNull($declarations);
        $this->assertNotEmpty($declarations);
        $this->assertEquals(1, sizeof($declarations));
        $this->assertEquals($declaration->Id, $declarations[0]->Id);
    }

    public function test_GetUboDeclaration()
    {
        $declaration = $this->getMatrixUboDeclaration();
        $matrix = $this->getMatrix();

        $declarationFromApi = $this->_api->UboDeclarations->GET($matrix->Id, $declaration->Id);

        $this->assertNotNull($declarationFromApi);
        $this->assertEquals($declaration->Id, $declarationFromApi->Id);
    }

    public function test_getUboDeclarationById()
    {
        $declaration = $this->getMatrixUboDeclaration();
        $declarationFromApi = $this->_api->UboDeclarations->GetUboDeclarationById($declaration->Id);
        $this->assertNotNull($declarationFromApi);
        $this->assertEquals($declaration->Id, $declarationFromApi->Id);
        $this->assertNotNull($declarationFromApi->UserId);
    }

    public function test_CreateUbo()
    {
        $ubo = $this->createNewUboForMatrix();
        $newUbo = $this->getMatrixUbo();

        $declaration = $this->getMatrixUboDeclaration();

        $this->assertNotEmpty($declaration->Id);
        $this->assertNotNull($newUbo);
        $this->assertNotNull($newUbo->Id);
        $this->assertEquals($ubo->FirstName, $newUbo->FirstName);
        $this->assertEquals($ubo->LastName, $newUbo->LastName);
        $this->assertEquals($ubo->Address, $newUbo->Address);
        $this->assertEquals($ubo->Nationality, $newUbo->Nationality);
        $this->assertEquals($ubo->Birthday, $newUbo->Birthday);
        $this->assertEquals($ubo->Birthplace, $newUbo->Birthplace);
    }

    public function test_throw_CreateUbo()
    {
        $matrix = $this->getMatrix();
        $ubo = $this->createNewUboForMatrix();
        $this->assertNotNull($ubo);
        $this->assertNotNull($matrix->Id);
        try {
            $this->_api->UboDeclarations->CreateUbo($matrix->Id, null, $ubo);
        } catch (ResponseException $e) {
            log($e->GetErrorCode());
        }
    }

    public function test_UpdateUbo()
    {
        $matrix = $this->getMatrix();
        $uboDeclaration = $this->getMatrixUboDeclaration();

        $toBeUpdated = $this->getMatrixUbo();
        $toBeUpdated->FirstName = "UpdatedFirstName";
        $toBeUpdated->LastName = "UpdatedLastName";
        $toBeUpdated->Address->AddressLine1 = "UpdatedLine1";
        $toBeUpdated->Nationality = "GB";
        $toBeUpdated->Birthday = mktime(0, 0, 0, 12, 21, 1991);
        $toBeUpdated->Birthplace->Country = "GB";

        $ubo = $this->_api->UboDeclarations->UpdateUbo($matrix->Id, $uboDeclaration->Id, $toBeUpdated);

        $this->assertEquals($toBeUpdated->FirstName, $ubo->FirstName);
        $this->assertEquals($toBeUpdated->LastName, $ubo->LastName);
        $this->assertEquals($toBeUpdated->Address, $ubo->Address);
        $this->assertEquals($toBeUpdated->Nationality, $ubo->Nationality);
        $this->assertEquals($toBeUpdated->Birthday, $ubo->Birthday);
        $this->assertEquals($toBeUpdated->Birthplace, $ubo->Birthplace);
    }

    public function test_GetUboById()
    {
        $uboDeclaration = $this->getMatrixUboDeclaration();
        $dd = $this->_api->UboDeclarations->GetById($uboDeclaration->Id);

        $this->assertNotNull($dd);
        $this->assertEquals($uboDeclaration->Id, $dd->Id);
    }

    public function test_GetUbo()
    {
        $matrix = $this->getMatrix();
        $uboDeclaration = $this->getMatrixUboDeclaration();
        $existingUbo = $this->getMatrixUbo();

        $dd = $this->_api->UboDeclarations->Get($matrix->Id, $uboDeclaration->Id);

        $fetchedUbo = $this->_api->UboDeclarations->GetUbo($matrix->Id, $uboDeclaration->Id, $existingUbo->Id);

        $this->assertNotNull($fetchedUbo);

        $this->assertEquals($existingUbo->FirstName, $fetchedUbo->FirstName);
        $this->assertEquals($existingUbo->LastName, $fetchedUbo->LastName);
        $this->assertEquals($existingUbo->Address, $fetchedUbo->Address);
        $this->assertEquals($existingUbo->Nationality, $fetchedUbo->Nationality);
        $this->assertEquals($existingUbo->Birthday, $fetchedUbo->Birthday);
        $this->assertEquals($existingUbo->Birthplace, $fetchedUbo->Birthplace);
    }

    public function test_SubmitForValidation()
    {
        $declaration = $this->getMatrixUboDeclaration();
        $matrix = $this->getMatrix();
        $existingUbo = $this->getMatrixUbo();
        $newDeclaration = $this->_api->UboDeclarations->SubmitForValidation($matrix->Id, $declaration->Id);

        $this->assertEquals($declaration->Id, $newDeclaration->Id);
    }
}
