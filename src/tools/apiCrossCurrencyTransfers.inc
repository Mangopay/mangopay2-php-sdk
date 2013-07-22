<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for cross-currency-transfers
 */
class ApiCrossCurrencyTransfers extends ApiBase {
    
    /**
     * Create new cross currency transfer
     * @param CrossCurrencyTransfer $crossCurrencyTransfer
     * @return MangoPay\CrossCurrencyTransfer Cross currency transfer object returned from API
     */
    public function Create($crossCurrencyTransfer) {
        return $this->CreateObject('cross-currency-transfers_create', $crossCurrencyTransfer, 'MangoPay\CrossCurrencyTransfer');
    }
    
    /**
     * Get cross currency transfer
     * @param type $crossCurrencyTransferId Cross currency transfer identifier
     * @return MangoPay\CrossCurrencyTransfer Cross currency transfer object returned from API
     */
    public function Get($crossCurrencyTransferId) {
        return $this->GetObject('cross-currency-transfers_get', $crossCurrencyTransferId, 'MangoPay\CrossCurrencyTransfer');
    }
}