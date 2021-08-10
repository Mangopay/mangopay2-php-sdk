<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for KYC documents
 */
class KycDocumentsTest extends Base
{
    public function test_KycDocuments_GetAll()
    {
        $this->getJohnsKycDocument();
        $pagination = new \MangoPay\Pagination(1, 20);

        $list = $this->_api->KycDocuments->GetAll($pagination);

        $kycDocument = $this->_api->Users->GetKycDocument($list[0]->UserId, $list[0]->Id);
        $this->assertInstanceOf('\MangoPay\KycDocument', $list[0]);
        $kycFromList = $this->getEntityFromList($kycDocument->Id, $list);
        $this->assertSame($kycFromList->Id, $kycDocument->Id);
        $this->assertIdenticalInputProps($kycDocument, $kycFromList);
        $this->assertSame(1, $pagination->Page);
        $this->assertSame(20, $pagination->ItemsPerPage);
        $this->assertTrue(isset($pagination->TotalPages));
        $this->assertTrue(isset($pagination->TotalItems));
    }

    public function test_KycDocuments_GetAll_SortByCreationDate()
    {
        $this->getJohnsKycDocument();
        $pagination = new \MangoPay\Pagination(1, 20);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);

        $list = $this->_api->KycDocuments->GetAll($pagination, $sorting);

        $this->assertTrue($list[0]->Id > $list[1]->Id);
    }

    public function test_KycDocuments_Get()
    {
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();

        $getKycDocument = $this->_api->KycDocuments->Get($kycDocument->Id);

        $this->assertSame($kycDocument->Id, $getKycDocument->Id);
        $this->assertSame($kycDocument->Status, $getKycDocument->Status);
        $this->assertSame($kycDocument->Type, $getKycDocument->Type);
        $this->assertSame($kycDocument->UserId, $user->Id);
    }

    public function test_KycDocuments_CreateConsult()
    {
        $kycDocument = $this->getJohnsKycDocument();

        $consults = $this->_api->KycDocuments->CreateKycDocumentConsult($kycDocument->Id);

        $this->assertNotNull($consults);
        $this->assertTrue(is_array($consults), 'Expected an array');
    }
}
