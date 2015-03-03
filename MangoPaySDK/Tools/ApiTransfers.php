<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for transfers
 */
class ApiTransfers extends ApiBase {

    /**
     * Create new transfer
     * @param \MangoPay\Entities\Transfer $transfer
     * @return \MangoPay\Entities\Transfer Transfer object returned from API
     */
    public function Create($transfer) {
        return $this->CreateObject('transfers_create', $transfer, '\MangoPay\Entities\Transfer');
    }

    /**
     * Get transfer
     * @param type $transferId Transfer identifier
     * @return \MangoPay\Entities\Transfer Transfer object returned from API
     */
    public function Get($transfer) {
        return $this->GetObject('transfers_get', $transfer, '\MangoPay\Entities\Transfer');
    }

    /**
     * Create refund for transfer object
     * @param type $transferId Transfer identifier
     * @param \MangoPay\Entities\Refund $refund Refund object to create
     * @return \MangoPay\Entities\Refund Object returned by REST API
     */
    public function CreateRefund($transferId, $refund) {
        return $this->CreateObject('transfers_createrefunds', $refund, '\MangoPay\Entities\Refund', $transferId);
    }
}
