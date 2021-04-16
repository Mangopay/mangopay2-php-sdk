<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for wallets
 */
class ApiWallets extends Libraries\ApiBase
{
    /**
     * Create new wallet
     * @param Wallet $wallet
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Create($wallet, $idempotencyKey = null)
    {
        return $this->CreateObject('wallets_create', $wallet, '\MangoPay\Wallet', null, null, $idempotencyKey);
    }

    /**
     * Get wallet
     * @param string $walletId Wallet identifier
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Get($walletId)
    {
        return $this->GetObject('wallets_get', '\MangoPay\Wallet', $walletId);
    }

    /**
     * Save wallet
     * @param Wallet $wallet Wallet object to save
     * @return \MangoPay\Wallet Wallet object returned from API
     */
    public function Update($wallet)
    {
        return $this->SaveObject('wallets_save', $wallet, '\MangoPay\Wallet');
    }

    /**
     * Get transactions for the wallet
     * @param string $walletId Wallet identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return \MangoPay\Transaction[] Transactions for wallet returned from API
     */
    public function GetTransactions($walletId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('wallets_alltransactions', $pagination, '\MangoPay\Transaction', $walletId, $filter, $sorting);
    }
}
