<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for wallets
 */
class ApiWallets extends ApiBase {
    
    /**
     * Create new wallet
     * @param Wallet $wallet
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Create($wallet) {
        return $this->CreateObject('wallets_create', $wallet, '\MangoPay\Wallet');
    }
    
    /**
     * Get wallet
     * @param type $walletId Wallet identifier
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Get($walletId) {
        return $this->GetObject('wallets_get', $walletId, '\MangoPay\Wallet');
    }
    
    /**
     * Save wallet
     * @param type $wallet Wallet object to save
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Save($wallet) {
        return $this->SaveObject('wallets_save', $wallet, '\MangoPay\Wallet');
    }
    
    /**
     * Get recurring pay-in orders for the wallet
     * @param type $walletId Wallet identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with \MangoPay\RecurringPayInOrder objects returned from API
     */
    public function RecurringPayInOrders($walletId, & $pagination = null) {
        return $this->GetList('wallets_allrecurringpayinorders', $pagination, '\MangoPay\RecurringPayInOrder', $walletId);
    }
    
    /**
     * Get transactions for the wallet
     * @param type $walletId Wallet identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @return array Array with \MangoPay\Transaction objects returned from API
     */
    public function Transactions($walletId, & $pagination = null, $filter = null) {
        return $this->GetList('wallets_alltransactions', $pagination, '\MangoPay\Transaction', $walletId, $filter);
    }
}