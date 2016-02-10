<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends Libraries\ApiBase
{
    /**
     * Create new pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Create($payIn, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, '\MangoPay\PayIn', null, null, $idempotencyKey);
    }
    
    /**
     * Get pay-in object
     * @param $payInId Pay-in identifier
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Get($payInId)
    {
        return $this->GetObject('payins_get', $payInId, '\MangoPay\PayIn');
    }
    
    /**
     * Create refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_createrefunds', $refund, '\MangoPay\Refund', $payInId, null, $idempotencyKey);
    }
    
    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Create new temporary immediate pay-in
     * @param \MangoPay\TemporaryImmediatePayIn $immediatePayIn Immediate pay-in object to create
     * @return \MangoPay\TemporaryImmediatePayIn Immediate pay-in object returned from API
     */
    public function CreateTemporaryImmediatePayIn($immediatePayIn, $idempotencyKey = null)
    {
        return $this->CreateObject('temp_immediatepayins_create', $immediatePayIn, '\MangoPay\TemporaryImmediatePayIn', null, null, $idempotencyKey);
    }
    
    private function GetPaymentKey($payIn)
    {
        if (!isset($payIn->PaymentDetails) || !is_object($payIn->PaymentDetails)) {
            throw new Libraries\Exception('Payment is not defined or it is not object type');
        }
        
        $className = str_replace('MangoPay\\PayInPaymentDetails', '', get_class($payIn->PaymentDetails));
        return strtolower($className);
    }
    
    private function GetExecutionKey($payIn)
    {
        if (!isset($payIn->ExecutionDetails) || !is_object($payIn->ExecutionDetails)) {
            throw new Libraries\Exception('Execution is not defined or it is not object type');
        }
        
        $className = str_replace('MangoPay\\PayInExecutionDetails', '', get_class($payIn->ExecutionDetails));
        return strtolower($className);
    }
}
