<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for informations
 */
class ApiInfo extends ApiBase {
    
    /**
     * Get informations
     * @return \MangoPay\Info MangoPay\Info object returned from API
     */
    public function Get() {
        return $this->GetObject('info_get', '', '\MangoPay\Info');
    }
    
    /**
     * @@TODO
     * Get informations about fee wallets
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return object \MangoPay\Info object returned from API
     */
    public function FeeWallets(& $pagination = null) {
        return $this->GetList('info_getfeewallets', $pagination);
    }
    
    /**
     * @@TODO
     * Get means of payment informations
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return object \MangoPay\Info object returned from API
     */
    public function MeansOfPayment(& $pagination = null) {
        return $this->GetList('info_getmeansofpayment', $pagination);
    }
}