<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for pay-outs
 */
class ApiPayOuts extends ApiBase {

    /**
     * Create new pay-out
     * @param PayOut $payOut
     * @return \MangoPay\Entities\PayOut Object returned from API
     */
    public function Create($payOut) {
        $paymentKey = $this->GetPaymentKey($payOut);
        return $this->CreateObject('payouts_' . $paymentKey . '_create', $payOut, '\MangoPay\Entities\PayOut');
    }

    /**
     * Get pay-out object
     * @param $payOutId PayOut identifier
     * @return \MangoPay\Entities\PayOut Object returned from API
     */
    public function Get($payOutId) {
        return $this->GetObject('payouts_get', $payOutId, '\MangoPay\Entities\PayOut');
    }

    private function GetPaymentKey($payOut) {

        if (!isset($payOut->MeanOfPaymentDetails) || !is_object($payOut->MeanOfPaymentDetails))
            throw new Exception('Mean of payment is not defined or it is not object type');

        $className = str_replace('MangoPay\\Types\\PayOutPaymentDetails', '', get_class($payOut->MeanOfPaymentDetails));
        return strtolower($className);
    }
}
