<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for refunds
 */
class ApiRefunds extends ApiBase {
   
    /**
     * Get refund object
     * @param int $refundId
     * @return \MangoPay\Refund
     */
    public function Get($refundId) {
        return $this->GetObject('refunds_get', $refundId, '\MangoPay\Refund');
    }
}