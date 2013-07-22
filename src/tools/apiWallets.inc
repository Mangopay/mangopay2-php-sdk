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
        return $this->CreateObject('wallets_create', $wallet, 'MangoPay\Wallet');
    }
    
    /**
     * Get wallet
     * @param type $walletId Wallet identifier
     * @return MangoPay\Wallet Wallet object returned from API
     */
    public function Get($walletId) {
        return $this->GetObject('wallets_get', $walletId, 'MangoPay\Wallet');
    }
    
    /**
     * Save wallet
     * @param type $wallet Wallet object to save
     * @return MangoPay\Wallet Wallet object returned from API
     */
    public function Save($wallet) {
        return $this->SaveObject('wallets_save', $wallet, 'MangoPay\Wallet');
    }
}
