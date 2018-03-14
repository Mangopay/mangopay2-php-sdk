<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for disputes
 */
/**
 * Class ApiDisputes
 * @package MangoPay
 */
class ApiDisputes extends Libraries\ApiBase
{
    
    /**
     * Gets dispute
     * @param int|GUID $disputeId Dispute identifier
     * @return \MangoPay\Dispute Dispute instance returned from API
     */
    public function Get($disputeId)
    {
        return $this->GetObject('disputes_get', $disputeId, '\MangoPay\Dispute');
    }
    
    /**
     * Get all disputes
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterDisputes $filter Filtering object
     * @return array Array with disputes
     */
    public function GetAll(& $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_all', $pagination, '\MangoPay\Dispute', null, $filter, $sorting);
    }
    
     /**
     * List Disputes that need settling
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return array Array with disputes
     */
    public function GetPendingSettlements(& $pagination = null, $sorting = null)
    {
        return $this->GetList('disputes_pendingsettlement', $pagination, '\MangoPay\Dispute', null, null, $sorting);
    }
    
    /**
     * Updates dispute's tag
     * @param \MangoPay\Dispute Dispute object to update
     * @return \MangoPay\Dispute Transfer instance returned from API
     */
    public function Update($dispute)
    {
        return $this->SaveObject('disputes_save_tag', $dispute, '\MangoPay\Dispute');
    }
    
    /**
     * Contests dispute
     * @param int|GUID $disputeId Dispute identifier
     * @param \MangoPay\Money $contestedFunds Contested funds
     * @return \MangoPay\Dispute Dispute instance returned from API
     */
    public function ContestDispute($disputeId, $contestedFunds)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        $dispute->ContestedFunds = $contestedFunds;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MangoPay\Dispute');
    }
    
    /**
     * This method is used to resubmit a Dispute if it is reopened requiring more docs 
     * @param int|GUID $disputeId Dispute identifier
     * @return \MangoPay\Dispute Dispute instance returned from API
     */
    public function ResubmitDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('disputes_save_contest_funds', $dispute, '\MangoPay\Dispute');
    }
    
    /**
     * Close dispute
     * @param int|GUID $disputeId Dispute identifier
     * @return \MangoPay\Dispute Dispute instance returned from API
     */
    public function CloseDispute($disputeId)
    {
        $dispute = new Dispute();
        $dispute->Id = $disputeId;
        return $this->SaveObject('dispute_save_close', $dispute, '\MangoPay\Dispute');
    }

    /**
     * Gets dispute's transactions
     * @param int|GUID $disputeId Dispute identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterTransactions $filter Filtering object
     * @return array List of Transaction instances returned from API
     * @throws Libraries\Exception
     */
    public function GetTransactions($disputeId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_transactions', $pagination, 'MangoPay\Transaction', $disputeId, $filter, $sorting);
    }

    /**
     * Gets dispute's documents for wallet
     * @param int|GUID $walletId Wallet identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterDisputes $filter Filtering object
     * @return array List of dispute instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDisputesForWallet($walletId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_for_wallet', $pagination, 'MangoPay\Dispute', $walletId, $filter, $sorting);
    }

    /**
     * Gets user's disputes
     * @param int|GUID $userId User identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterDisputes $filter Filtering object
     * @return array List of Dispute instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDisputesForUser($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_get_for_user', $pagination, 'MangoPay\Dispute', $userId, $filter, $sorting);
    }
    
    /**
     * Gets repudiation
     * @param int|GUID $repudiationId Repudiation identifier
     * @return \MangoPay\Repudiation Repudiation instance returned from API
     */
    public function GetRepudiation($repudiationId)
    {
        return $this->GetObject('disputes_repudiation_get', $repudiationId, 'MangoPay\Repudiation');
    }
    
    /**
     * Creates settlement transfer
     * @param \MangoPay\SettlementTransfer $settlementTransfer Settlement transfer
     * @param int|GUID $repudiationId Repudiation identifier
     * @return \MangoPay\Transfer Transfer instance returned from API
     */
    public function CreateSettlementTransfer($settlementTransfer, $repudiationId, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_repudiation_create_settlement', $settlementTransfer, '\MangoPay\Transfer', $repudiationId, null, $idempotencyKey);
    }
    
    /**
     * Gets settlement transfer
     * @param int|GUID $settlementTransferId Settlement transfer identifier
     * @return \MangoPay\Transfer Transfer instance returned from API
     */
    public function GetSettlementTransfer($settlementTransferId)
    {
        return $this->GetObject('disputes_repudiation_get_settlement', $settlementTransferId, '\MangoPay\SettlementTransfer');
    }

    /**
     * Gets documents for dispute
     * @param int|GUID $disputeId Dispute identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterDisputeDocuments $filter Filtering object
     * @return array List of DisputeDocument instances returned from API
     * @throws Libraries\Exception
     */
    public function GetDocumentsForDispute($disputeId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('disputes_document_get_for_dispute', $pagination, 'MangoPay\DisputeDocument', $disputeId, $filter, $sorting);
    }
        
    /**
     * Update dispute document
     * @param int|GUID $disputeId Dispute identifier
     * @param \MangoPay\DisputeDocument $disputeDocument Dispute document to save
     * @return \MangoPay\DisputeDocument Document returned from API
     */
    public function UpdateDisputeDocument($disputeId, $disputeDocument)
    {
        return $this->SaveObject('disputes_document_save', $disputeDocument, '\MangoPay\DisputeDocument', $disputeId);
    }
        
    /**
     * Creates document for dispute
     * @param int|GUID $disputeId Dispute identifier
     * @param \MangoPay\DisputeDocument $disputeDocument Dispute document to be created
     * @return \MangoPay\DisputeDocument Dispute document returned from API
     */
    public function CreateDisputeDocument($disputeId, $disputeDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('disputes_document_create', $disputeDocument, '\MangoPay\DisputeDocument', $disputeId, null, $idempotencyKey);
    }
    
    /**
     * Creates document's page for dispute
     * @param int|GUID $disputeId Dispute identifier
     * @param int|GUID $disputeDocumentId Dispute document identifier
     * @param \MangoPay\DisputeDocumentPage $disputeDocumentPage Dispute document page object
     */
    public function CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('disputes_document_page_create', $disputeDocumentPage, null, $disputeId, $disputeDocumentId, $idempotencyKey);
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }
    
    /**
     * Creates document's page for dispute from file
     * @param int|GUID $disputeId Dispute identifier
     * @param int|GUID $disputeDocumentId Dispute document identifier
     * @param string $file File path
     * @throws \MangoPay\Libraries\Exception
     */
    public function CreateDisputeDocumentPageFromFile($disputeId, $disputeDocumentId, $file, $idempotencyKey = null)
    {
        $filePath = $file;
        if (is_array($file)) {
            $filePath = $file['tmp_name'];
        }
        
        if (empty($filePath)) {
            throw new \MangoPay\Libraries\Exception('Path of file cannot be empty');
        }
        
        if (!file_exists($filePath)) {
            throw new \MangoPay\Libraries\Exception('File not exist');
        }
        
        $disputeDocumentPage = new \MangoPay\DisputeDocumentPage();
        $disputeDocumentPage->File = base64_encode(file_get_contents($filePath));
        
        if (empty($disputeDocumentPage->File)) {
            throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
        }
        
        $this->CreateDisputeDocumentPage($disputeId, $disputeDocumentId, $disputeDocumentPage, $idempotencyKey);
    }
}
