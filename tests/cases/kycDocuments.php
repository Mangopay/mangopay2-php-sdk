<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for KYC documents
 */
class KycDocuments extends Base {

    function test_KycDocuments_GetAll() {
        $this->getJohnsKycDocument();
        $pagination = new \MangoPay\Pagination(1, 20);
        
        $list = $this->_api->KycDocuments->GetAll($pagination);
        
        $kycDocument = $this->_api->Users->GetKycDocument($list[0]->UserId, $list[0]->Id);
        $this->assertIsA($list[0], '\MangoPay\KycDocument');
        $kycFromList = $this->getEntityFromList($kycDocument->Id, $list);
        $this->assertIdentical($kycDocument->Id, $kycFromList->Id);
        $this->assertIdenticalInputProps($kycDocument, $kycFromList);
        $this->assertIdentical($pagination->Page, 1);
        $this->assertIdentical($pagination->ItemsPerPage, 20);
        $this->assertTrue(isset($pagination->TotalPages));
        $this->assertTrue(isset($pagination->TotalItems));
    }
    
    function test_KycDocuments_GetAll_SortByCreationDate() {
        $this->getJohnsKycDocument();
        $pagination = new \MangoPay\Pagination(1, 20);
        $sorting = new \MangoPay\Sorting();
        $sorting->AddField("CreationDate", \MangoPay\SortDirection::DESC);
        
        $list = $this->_api->KycDocuments->GetAll($pagination, $sorting);

        $this->assertTrue($list[0]->Id > $list[1]->Id);
    }
	
	function test_KycDocuments__Get(){
        $kycDocument = $this->getJohnsKycDocument();
        $user = $this->getJohn();
        
        $getKycDocument = $this->_api->KycDocuments->Get($kycDocument->Id);
        
        $this->assertIdentical($kycDocument->Id, $getKycDocument->Id);
        $this->assertIdentical($kycDocument->Status, $getKycDocument->Status);
        $this->assertIdentical($kycDocument->Type, $getKycDocument->Type);
        $this->assertIdentical($kycDocument->UserId, $user->Id);
    }
}