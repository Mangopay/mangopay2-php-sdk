<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends ApiBase {

    /**
     * Create new pay-in object
     * @param \MangoPay\Entities\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\Entities\PayIn Object returned from API
     */
    public function Create($payIn) {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, '\MangoPay\Entities\PayIn');
    }

    /**
     * Get pay-in object
     * @param $payInId Pay-in identifier
     * @return \MangoPay\Entities\PayIn Object returned from API
     */
    public function Get($payInId) {
        return $this->GetObject('payins_get', $payInId, '\MangoPay\Entities\PayIn');
    }

    /**
     * Create refund for pay-in object
     * @param type $payInId Pay-in identifier
     * @param \MangoPay\Entities\Refund $refund Refund object to create
     * @return \MangoPay\Entities\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund) {
        return $this->CreateObject('payins_createrefunds', $refund, '\MangoPay\Entities\Refund', $payInId);
    }

    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Create new temporary immediate pay-in
     * @param \MangoPay\Entities\TemporaryImmediatePayIn $immediatePayIn Immediate pay-in object to create
     * @return \MangoPay\Entities\TemporaryImmediatePayIn Immediate pay-in object returned from API
     */
    public function CreateTemporaryImmediatePayIn($immediatePayIn) {
        return $this->CreateObject('temp_immediatepayins_create', $immediatePayIn, '\MangoPay\Entities\TemporaryImmediatePayIn');
    }

    private function GetPaymentKey($payIn) {

        if (!isset($payIn->PaymentDetails) || !is_object($payIn->PaymentDetails))
            throw new Exception ('Payment is not defined or it is not object type');

        $className = str_replace('MangoPay\\Types\\PayInPaymentDetails', '', get_class($payIn->PaymentDetails));
        return strtolower($className);
    }

    private function GetExecutionKey($payIn) {

        if (!isset($payIn->ExecutionDetails) || !is_object($payIn->ExecutionDetails))
            throw new Exception ('Execution is not defined or it is not object type');

        $className = str_replace('MangoPay\\Types\\PayInExecutionDetails', '', get_class($payIn->ExecutionDetails));
        return strtolower($className);
    }
}
