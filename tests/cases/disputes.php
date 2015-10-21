<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for disputes
 */
class Disputes extends Base {
    
    /* IMPORTANT NOTE!
    * 
    * Due to the fact the disputes CANNOT be created on user's side,
    * a special approach in testing is needed. 
    * In order to get the tests below pass, a bunch of disputes have
    * to be prepared on the API's side - if they're not, you can
    * just skip these tests, as they won't pass.
    * 
    */
    
    private $_clientDisputes = null;
    private $_canTestDisputes = true;
    
    function setUp(){
        $pagination = new \MangoPay\Pagination(1, 100);
        $this->_clientDisputes = $this->_api->Disputes->GetAll($pagination);
        if (is_null($this->_clientDisputes) || count($this->_clientDisputes) == 0){
            $this->_canTestDisputes = false;
        }
    }
    
    function canTest(){
        if (!$this->_canTestDisputes)
            $this->assertTrue(false, 'INITIALIZATION FAILURE - cannot test disputes. Not exist any dispute.');
        
        return $this->_canTestDisputes;
    }
    
    function test_Disputes_Get() {
        if (!$this->canTest()) return;
                
        $dispute = $this->_api->Disputes->Get($this->_clientDisputes[0]->Id);
        
        $this->assertNotNull($dispute);
        $this->assertEqual($this->_clientDisputes[0]->Id, $dispute->Id);
    }
    
    function test_Disputes_GetTransactions() {
        if (!$this->canTest()) return;
        $pagination = new \MangoPay\Pagination();
        
        $result = $this->_api->Disputes->GetTransactions($this->_clientDisputes[0]->Id, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_GetDisputesForWallet() {
        if (!$this->canTest()) return;
        $disputeWallet = null;
        foreach($this->_clientDisputes as $dispute){
            if (!is_null($dispute->InitialTransactionId)){
                $disputeWallet = $dispute;
                break;
            }
        }        
        if (is_null($disputeWallet)){
            $this->assertTrue(false, "Cannot test getting disputes for wallet because there's no disputes with transaction ID in the disputes list.");
            return;
        }      
        $pagination = new \MangoPay\Pagination();
        $wallet = $this->_api->PayIns->Get($disputeWallet->InitialTransactionId);

        $result = $this->_api->Disputes->GetDisputesForWallet($wallet->CreditedWalletId, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_GetDisputesForUser() {
        if (!$this->canTest()) return;
         
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($this->_clientDisputes[0]->Id, $pagination);
        $userId = $transactions[0]->AuthorId;
        $result = $this->_api->Disputes->GetDisputesForUser($userId, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_CreateDisputeDocument() {
        if (!$this->canTest()) return;
        $disputeForDoc = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForDoc = $dispute;
                break;
            }
        }        
        if (is_null($disputeForDoc)){
            $this->assertTrue(false, "Cannot test creating dispute document because there's no dispute with expected status in the disputes list.");
            return;
        }      
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        
        $result = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Type, \MangoPay\DisputeDocumentType::DeliveryProof);
    }
    
    function test_Disputes_CreateDisputePage() {
        if (!$this->canTest()) return;
        $disputeForDoc = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForDoc = $dispute;
                break;
            }
        }        
        if (is_null($disputeForDoc)){
            $this->assertTrue(false, "Cannot test creating dispute document page because there's no dispute with expected status in the disputes list.");
            return;
        }      
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $documentCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);

        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForDoc->Id, $documentCreated->Id, __DIR__ ."/../TestKycPageFile.png");
    }
    
    function test_Disputes_ContestDispute() {
        if (!$this->canTest()) return;
        $notContestedDispute = null;
        foreach($this->_clientDisputes as $dispute){
            if (($dispute->DisputeType == \MangoPay\DisputeType::Contestable
                    || $dispute->DisputeType == \MangoPay\DisputeType::Retrieval)
                 && ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction)){
                $notContestedDispute = $dispute;
                break;
            }
        }        
        if (is_null($notContestedDispute)){
            $this->assertTrue(false, "Cannot test contesting dispute because there's no disputes that can be contested in the disputes list.");
            return;
        }      
        $contestedFunds = null;
        if ($notContestedDispute->Status == \MangoPay\DisputeStatus::PendingClientAction){
            $contestedFunds = new \MangoPay\Money();
            $contestedFunds->Amount = 10;
            $contestedFunds->Currency = "EUR";
        }

        $result = $this->_api->Disputes->ContestDispute($notContestedDispute->Id, $contestedFunds);

        $this->assertNotNull($result);
        $this->assertEqual($result->Id, $notContestedDispute->Id);
        $this->assertEqual($result->Status, \MangoPay\DisputeStatus::Submitted);
    }
    
    function test_Disputes_ResubmitDispute() {
        if (!$this->canTest()) return;
        $toTestDispute = null;
        foreach($this->_clientDisputes as $dispute){
            if (($dispute->DisputeType == \MangoPay\DisputeType::Contestable
                    || $dispute->DisputeType == \MangoPay\DisputeType::Retrieval)
                 && ($dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction)){
                $toTestDispute = $dispute;
                break;
            }
        }        
        if (is_null($toTestDispute)){
            $this->assertTrue(false, "Cannot test contesting dispute because there's no disputes that can be resubmited in the disputes list.");
            return;
        }      
        
        $result = $this->_api->Disputes->ResubmitDispute($toTestDispute->Id);

        $this->assertNotNull($result);
        $this->assertEqual($result->Id, $toTestDispute->Id);
        $this->assertEqual($result->Status, \MangoPay\DisputeStatus::Submitted);
    }
    
    function test_Disputes_Update() {
        if (!$this->canTest()) return;
        $newTag = "New tag " . time();
        $dispute = new \MangoPay\Dispute();
        $dispute->Id = $this->_clientDisputes[0]->Id;
        $dispute->Tag = $newTag;

        $result = $this->_api->Disputes->Update($dispute);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Tag, $newTag);
    }
    
    function test_Disputes_CloseDispute() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test closing dispute because there's no available disputes with expected status in the disputes list.");
            return;
        }

        $result = $this->_api->Disputes->CloseDispute($disputeForTest->Id);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Status, \MangoPay\DisputeStatus::Closed);
    }
    
    function test_Disputes_GetDocument() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test getting dispute's document because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::Other;
        $docCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForTest->Id, $document);
        
        $result = $this->_api->DisputeDocuments->Get($docCreated->Id);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->CreationDate, $docCreated->CreationDate);
        $this->assertEqual($result->Id, $docCreated->Id);
        $this->assertEqual($result->RefusedReasonMessage, $docCreated->RefusedReasonMessage);
        $this->assertEqual($result->RefusedReasonType, $docCreated->RefusedReasonType);
        $this->assertEqual($result->Status, $docCreated->Status);
        $this->assertEqual($result->Tag, $docCreated->Tag);
        $this->assertEqual($result->Type, $docCreated->Type);
    }
    
    function test_Disputes_GetDocumentsForDispute() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::Submitted){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test getting dispute's documents because there's no available disputes with SUBMITTED status in the disputes list.");
            return;
        }
        
        $result = $this->_api->Disputes->GetDocumentsForDispute($disputeForTest->Id);
        
        $this->assertNotNull($result);
    }
    
    function test_Disputes_GetAllDocuments() {
        if (!$this->canTest()) return;
        
        $pagination = new \MangoPay\Pagination();
        $result = $this->_api->DisputeDocuments->GetAll($pagination);
        
        $this->assertNotNull($result);
    }
    
    function test_Disputes_UpdateDisputeDocument() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test submitting dispute's documents because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $disputeDocument = $this->_api->Disputes->CreateDisputeDocument($disputeForTest->Id, $document);
        $disputeDocument->Status = \MangoPay\DisputeDocumentStatus::ValidationAsked;
        
        $result = $this->_api->Disputes->UpdateDisputeDocument($disputeForTest->Id, $disputeDocument);

        $this->assertNotNull($result);
        $this->assertEqual($disputeDocument->Type, $result->Type);
        $this->assertTrue($result->Status == \MangoPay\DisputeDocumentStatus::ValidationAsked);
    }
    
    function test_Disputes_GetRepudiation() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if (!is_null($dispute->InitialTransactionId)){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test getting repudiation because there's no disputes with transaction ID in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($disputeForTest->Id, $pagination);
        $repudiationId = $transactions[0]->Id;
        
        $result = $this->_api->Disputes->GetRepudiation($repudiationId);
        
        $this->assertNotNull($result);
        $this->assertEqual($repudiationId, $result->Id);
    }
    
    function test_Disputes_CreateSettlementTransfer() {
        if (!$this->canTest()) return;
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::Closed){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->assertTrue(false, "Cannot test creating settlement transfer because there's no closed disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($disputeForTest->Id, $pagination);
        $repudiationId = $transactions[0]->Id;
        $repudiation = $this->_api->Disputes->GetRepudiation($repudiationId);
        $settlementTransfer = new \MangoPay\SettlementTransfer();
        $settlementTransfer->AuthorId = $repudiation->AuthorId;
        $settlementTransfer->DebitedFunds = new \MangoPay\Money();
        $settlementTransfer->DebitedFunds->Amount = 1;
        $settlementTransfer->DebitedFunds->Currency = "EUR";
        $settlementTransfer->Fees = new \MangoPay\Money();
        $settlementTransfer->Fees->Amount = 0;
        $settlementTransfer->Fees->Currency = "EUR";
        
        $result = $this->_api->Disputes->CreateSettlementTransfer($settlementTransfer, $repudiationId);

        $this->assertNotNull($result);
    }
}