<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends ApiBase {
    
    /**
     * Create new pay-in object
     * @return MangoPay\PayIn Object returned from API
     */
    public function Create($payIn) {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('pay-ins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, 'MangoPay\PayIn');
    }
    
    /**
     * Get pay-in object
     * @param  $payInId Pay-in identifier
     * @return MangoPay\PayIn Object returned from API
     */
    public function Get($payInId) {
        return $this->GetObject('pay-ins_get', $payInId, 'MangoPay\PayIn');
    }
    
    /**
     * Create refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @param MangoPay\Refund $refund Refund object to create
     * @return MangoPay\Refund Object returned by REST API
     */
    public function CreateRefunds($payInId, $refund) {
        return $this->CreateObject('pay-ins_createrefunds', $payInId, 'MangoPay\Refund', $refund);
    }
    
    private function GetPaymentKey($payIn) {
        
        if (!isset($payIn->MeanOfPayment) || !is_object($payIn->MeanOfPayment))
            throw new Exception ('Mean of payment is not defined or it is not object type');
        
        $className = str_replace('MangoPay\\', '', get_class($payIn->MeanOfPayment));
        return strtolower($className);
    }
    
    private function GetExecutionKey($payIn) {
        
        if (!isset($payIn->Execution) || !is_object($payIn->Execution))
            throw new Exception ('Execution is not defined or it is not object type');
        
        $className = str_replace('MangoPay\\', '', get_class($payIn->Execution));
        return strtolower($className);
    }
}