<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends ApiBase {
    
    /**
     * Create new pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Create($payIn) {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, '\MangoPay\PayIn');
    }
    
    /**
     * Get pay-in object
     * @param $payInId Pay-in identifier
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Get($payInId) {
        return $this->GetObject('payins_get', $payInId, '\MangoPay\PayIn');
    }
    
    /**
     * Create refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund) {
        return $this->CreateObject('payins_createrefunds', $payInId, '\MangoPay\Refund', $refund);
    }

    /**
     * Get refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function Refund($payInId) {
        return $this->GetObject('payins_getrefunds', $payInId, '\MangoPay\Refund');
    }
    
    private function GetPaymentKey($payIn) {
        
        if (!isset($payIn->Payment) || !is_object($payIn->Payment))
            throw new Exception ('Payment is not defined or it is not object type');
        
        $className = str_replace('MangoPay\\', '', get_class($payIn->Payment));
        return strtolower($className);
    }
    
    private function GetExecutionKey($payIn) {
        
        if (!isset($payIn->Execution) || !is_object($payIn->Execution))
            throw new Exception ('Execution is not defined or it is not object type');
        
        $className = str_replace('MangoPay\\', '', get_class($payIn->Execution));
        return strtolower($className);
    }
}