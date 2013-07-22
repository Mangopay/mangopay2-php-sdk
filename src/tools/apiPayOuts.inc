<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pay-outs
 */
class ApiPayOuts extends ApiBase {
    
    /**
     * Create new pay-out
     * @param PayOut $payOut
     * @return MangoPay\PayOut Object returned from API
     */
    public function Create($payOut) {
        $paymentKey = $this->GetPaymentKey($payOut);
        return $this->CreateObject('pay-outs_' . $paymentKey . '_create', $payOut, 'MangoPay\PayOut');
    }
    
    /**
     * Get pay-out object
     * @param  $payOutId PayOut identifier
     * @return MangoPay\PayOut Object returned from API
     */
    public function Get($payOutId) {
        return $this->GetObject('pay-outs_get', $payOutId, 'MangoPay\PayOut');
    }
    
    /**
     * Create refund for pay-out object
     * @param type $payOutId Pay-out identifier
     * @param MangoPay\Refund $refund Refund object to create
     * @return MangoPay\Refund Object returned by REST API
     */
    public function CreateRefunds($payOutId, $refund) {
        return $this->CreateObject('pay-outs_createrefunds', $payOutId, 'MangoPay\Refund', $refund);
    }
    
    private function GetPaymentKey($payOut) {
        
        if (!isset($payOut->MeanOfPayment) || !is_object($payOut->MeanOfPayment))
            throw new Exception ('Mean of payment is not defined or it is not object type');
        
        $className = str_replace('MangoPay\\', '', get_class($payOut->MeanOfPayment));
        return strtolower($className);
    }
}