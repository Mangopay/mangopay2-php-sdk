<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for pay-outs
 */
class ApiPayOuts extends Libraries\ApiBase
{
    /**
     * Create new pay-out
     * @param PayOut $payOut
     * @return \MangoPay\PayOut Object returned from API
     */
    public function Create($payOut, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payOut);
        return $this->CreateObject('payouts_' . $paymentKey . '_create', $payOut, '\MangoPay\PayOut', null, null, $idempotencyKey);
    }
    
    /**
     * Get pay-out object
     * @param string $payOutId PayOut identifier
     * @return \MangoPay\PayOut Object returned from API
     */
    public function Get($payOutId)
    {
        return $this->GetObject('payouts_get', $payOutId, '\MangoPay\PayOut');
    }

    /**
     * Returns a list of Refunds pertaining to a certain PayOut.
     * @param string $payOutId ID of the PayOut for which to retrieve Refunds
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterRefunds filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return array List of Refunds for the PayOut
     */
    public function GetRefunds($payOutId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_payout', $pagination, '\MangoPay\Refund', $payOutId, $filter, $sorting);
    }
    
    private function GetPaymentKey($payOut)
    {
        if (!isset($payOut->MeanOfPaymentDetails) || !is_object($payOut->MeanOfPaymentDetails)) {
            throw new Libraries\Exception('Mean of payment is not defined or it is not object type');
        }
        
        $className = str_replace('MangoPay\\PayOutPaymentDetails', '', get_class($payOut->MeanOfPaymentDetails));
        return strtolower($className);
    }
}
