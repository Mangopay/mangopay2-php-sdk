<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for refunds
 */
class ApiRefunds extends ApiBase {

    /**
     * Get refund object
     * @param string $refundId Refund Id
     * @return \MangoPay\Entities\Refund Refund object returned from API
     */
    public function Get($refundId) {
        return $this->GetObject('refunds_get', $refundId, '\MangoPay\Entities\Refund');
    }
}
