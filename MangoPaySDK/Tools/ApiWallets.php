<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for wallets
 */
class ApiWallets extends ApiBase {

    /**
     * Create new wallet
     * @param Wallet $wallet
     * @return \MangoPay\Entities\Wallet Wallet object returned from API
     */
    public function Create($wallet) {
        return $this->CreateObject('wallets_create', $wallet, '\MangoPay\Entities\Wallet');
    }

    /**
     * Get wallet
     * @param int $walletId Wallet identifier
     * @return \MangoPay\Entities\Wallet Wallet object returned from API
     */
    public function Get($walletId) {
        return $this->GetObject('wallets_get', $walletId, '\MangoPay\Entities\Wallet');
    }

    /**
     * Save wallet
     * @param Wallet $wallet Wallet object to save
     * @return \MangoPay\Entities\Wallet Wallet object returned from API
     */
    public function Update($wallet) {
        return $this->SaveObject('wallets_save', $wallet, '\MangoPay\Entities\Wallet');
    }

    /**
     * Get transactions for the wallet
     * @param type $walletId Wallet identifier
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Tools'Sorting $sorting Object to sorting data
     * @return \MangoPay\Entities\Transaction[] Transactions for wallet returned from API
     */
    public function GetTransactions($walletId, & $pagination = null, $filter = null, $sorting = null) {
        return $this->GetList('wallets_alltransactions', $pagination, '\MangoPay\Entities\Transaction', $walletId, $filter, $sorting);
    }
}
