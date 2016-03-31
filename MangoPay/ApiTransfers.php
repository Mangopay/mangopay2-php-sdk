<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for transfers
 */
class ApiTransfers extends Libraries\ApiBase
{
    /**
     * Create new transfer
     * @param \MangoPay\Transfer $transfer
     * @return \MangoPay\Transfer Transfer object returned from API
     */
    public function Create($transfer, $idempotencyKey = null)
    {
        return $this->CreateObject('transfers_create', $transfer, '\MangoPay\Transfer', null, null, $idempotencyKey);
    }
    
    /**
     * Get transfer
     * @param string $transferId Transfer identifier
     * @return \MangoPay\Transfer Transfer object returned from API
     */
    public function Get($transferId)
    {
        return $this->GetObject('transfers_get', $transferId, '\MangoPay\Transfer');
    }
    
    /**
     * Create refund for transfer object
     * @param string $transferId Transfer identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreateRefund($transferId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('transfers_createrefunds', $refund, '\MangoPay\Refund', $transferId, null, $idempotencyKey);
    }
}
