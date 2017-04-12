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

    public function skip()
    {
        $this->_clientDisputes = $this->_api->Disputes->GetAll(new \MangoPay\Pagination(1, 100));
        $this->skipIf(empty($this->_clientDisputes), 'INITIALIZATION FAILURE - cannot test disputes. Not exist any dispute.');
    }

    function test_Disputes_Get() {
        $dispute = $this->_api->Disputes->Get($this->_clientDisputes[0]->Id);
        
        $this->assertNotNull($dispute);
        $this->assertEqual($this->_clientDisputes[0]->Id, $dispute->Id);
    }
    
    function test_Disputes_GetTransactions() {
        $disputeToTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->DisputeType == \MangoPay\DisputeType::NotContestable){
                $disputeToTest = $dispute;
                break;
            }
        }
        if (is_null($disputeToTest)){
            $this->reporter->paintSkip("Cannot test getting transactions for dispute because there's no not costestable disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        
        $result = $this->_api->Disputes->GetTransactions($disputeToTest->Id, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_GetDisputesForWallet() {
        $disputeWallet = null;
        foreach($this->_clientDisputes as $dispute){
            if (!is_null($dispute->InitialTransactionId)){
                $disputeWallet = $dispute;
                break;
            }
        }        
        if (is_null($disputeWallet)){
            $this->reporter->paintSkip("Cannot test getting disputes for wallet because there's no disputes with transaction ID in the disputes list.");
            return;
        }      
        $pagination = new \MangoPay\Pagination();
        $wallet = $this->_api->PayIns->Get($disputeWallet->InitialTransactionId);

        $result = $this->_api->Disputes->GetDisputesForWallet($wallet->CreditedWalletId, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_GetDisputesForUser() {
        $disputeToTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->DisputeType == \MangoPay\DisputeType::NotContestable){
                $disputeToTest = $dispute;
                break;
            }
        }
        if (is_null($disputeToTest)){
            $this->reporter->paintSkip("Cannot test getting disputes for user because there's no not costestable disputes in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($dispute->Id, $pagination);
        $userId = $transactions[0]->AuthorId;
        $result = $this->_api->Disputes->GetDisputesForUser($userId, $pagination);
        
        $this->assertNotNull($result);
        $this->assertTrue(count($result) > 0);
    }
    
    function test_Disputes_CreateDisputeDocument() {
        $disputeForDoc = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForDoc = $dispute;
                break;
            }
        }        
        if (is_null($disputeForDoc)){
            $this->reporter->paintSkip("Cannot test creating dispute document because there's no dispute with expected status in the disputes list.");
            return;
        }      
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        
        $result = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Type, \MangoPay\DisputeDocumentType::DeliveryProof);
		$this->assertEqual($result->DisputeId, $disputeForDoc->Id);
    }
    
    function test_Disputes_CreateDisputePage() {
        $disputeForDoc = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForDoc = $dispute;
                break;
            }
        }        
        if (is_null($disputeForDoc)){
            $this->reporter->paintSkip("Cannot test creating dispute document page because there's no dispute with expected status in the disputes list.");
            return;
        }      
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $documentCreated = $this->_api->Disputes->CreateDisputeDocument($disputeForDoc->Id, $document);

        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForDoc->Id, $documentCreated->Id, __DIR__ ."/../TestKycPageFile.png");
    }
    
    function test_Disputes_ContestDispute() {
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
            $this->reporter->paintSkip("Cannot test contesting dispute because there's no disputes that can be contested in the disputes list.");
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

		return $result; // used in test_Disputes_GetDocumentsForDispute()
    }
    
    function test_Disputes_ResubmitDispute() {
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
            $this->reporter->paintSkip("Cannot test contesting dispute because there's no disputes that can be resubmited in the disputes list.");
            return;
        }      
        
        $result = $this->_api->Disputes->ResubmitDispute($toTestDispute->Id);

        $this->assertNotNull($result);
        $this->assertEqual($result->Id, $toTestDispute->Id);
        $this->assertEqual($result->Status, \MangoPay\DisputeStatus::Submitted);
    }
    
    function test_Disputes_Update() {
        $newTag = "New tag " . time();
        $dispute = new \MangoPay\Dispute();
        $dispute->Id = $this->_clientDisputes[0]->Id;
        $dispute->Tag = $newTag;

        $result = $this->_api->Disputes->Update($dispute);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Tag, $newTag);
    }
    
    function test_Disputes_CloseDispute() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test closing dispute because there's no available disputes with expected status in the disputes list.");
            return;
        }

        $result = $this->_api->Disputes->CloseDispute($disputeForTest->Id);
        
        $this->assertNotNull($result);
        $this->assertEqual($result->Status, \MangoPay\DisputeStatus::Closed);
    }
    
    function test_Disputes_GetDocument() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test getting dispute's document because there's no dispute with expected status in the disputes list.");
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
        $this->assertEqual($result->DisputeId, $disputeForTest->Id);
    }
    
    function test_Disputes_GetDocumentsForDispute() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::Submitted){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $disputeForTest = $this->test_Disputes_ContestDispute();
        }
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test getting dispute's documents because there's no available disputes with SUBMITTED status in the disputes list.");
            return;
        }
        
        $result = $this->_api->Disputes->GetDocumentsForDispute($disputeForTest->Id);
        
        $this->assertNotNull($result);
    }
    
    function test_Disputes_GetAllDocuments() {
        $pagination = new \MangoPay\Pagination();
        $result = $this->_api->DisputeDocuments->GetAll($pagination);
        
        $this->assertNotNull($result);
    }
    
    function test_Disputes_UpdateDisputeDocument() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::PendingClientAction
                    || $dispute->Status == \MangoPay\DisputeStatus::ReopenedPendingClientAction){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test submitting dispute's documents because there's no dispute with expected status in the disputes list.");
            return;
        }
        $document = new \MangoPay\DisputeDocument();
        $document->Type = \MangoPay\DisputeDocumentType::DeliveryProof;
        $disputeDocument = $this->_api->Disputes->CreateDisputeDocument($disputeForTest->Id, $document);
        
        $this->_api->Disputes->CreateDisputeDocumentPageFromFile($disputeForTest->Id, $disputeDocument->Id, __DIR__ ."/../TestKycPageFile.png");
        
        $disputeDocument->Status = \MangoPay\DisputeDocumentStatus::ValidationAsked;
        
        $result = $this->_api->Disputes->UpdateDisputeDocument($disputeForTest->Id, $disputeDocument);

        $this->assertNotNull($result);
        $this->assertEqual($disputeDocument->Type, $result->Type);
        $this->assertTrue($result->Status == \MangoPay\DisputeDocumentStatus::ValidationAsked);
    }
    
    function test_Disputes_GetRepudiation() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if (!is_null($dispute->InitialTransactionId && $dispute->DisputeType == \MangoPay\DisputeType::NotContestable)){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test getting repudiation because there's no not costestable disputes with transaction ID in the disputes list.");
            return;
        }
        $pagination = new \MangoPay\Pagination();
        $transactions = $this->_api->Disputes->GetTransactions($disputeForTest->Id, $pagination);

        if (empty($transactions)) {
            $this->reporter->paintSkip("Cannot test getting repudiation because dispute has no transaction.");
            return;
        }

        $repudiationId = $transactions[0]->Id;
        
        $result = $this->_api->Disputes->GetRepudiation($repudiationId);
        
        $this->assertNotNull($result);
        $this->assertEqual($repudiationId, $result->Id);
    }
    
    function test_Disputes_CreateSettlementTransfer() {
        $disputeForTest = null;
        foreach($this->_clientDisputes as $dispute){
            if ($dispute->Status == \MangoPay\DisputeStatus::Closed && $dispute->DisputeType == \MangoPay\DisputeType::NotContestable){
                $disputeForTest = $dispute;
                break;
            }
        }        
        if (is_null($disputeForTest)){
            $this->reporter->paintSkip("Cannot test creating settlement transfer because there's no closed, not costestable disputes in the disputes list.");
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
        
        $transfer = $this->_api->Disputes->CreateSettlementTransfer($settlementTransfer, $repudiationId);
        $this->assertNotNull($transfer);
        $this->assertTrue($transfer->Type == 'TRANSFER');
        $this->assertTrue($transfer->Nature == 'SETTLEMENT');
        
        $fetchedTransfer = $this->_api->Disputes->GetSettlementTransfer($transfer->Id);
        $this->assertTrue($transfer->Id == $fetchedTransfer->Id);
        $this->assertTrue($transfer->CreationDate == $fetchedTransfer->CreationDate);
    }
}
