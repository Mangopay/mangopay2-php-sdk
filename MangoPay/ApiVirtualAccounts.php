<?php

namespace MangoPay;

class ApiVirtualAccounts extends Libraries\ApiBase
{
    /**
     * Create new Virtual Account
     * @param String $walletId
     * @return \MangoPay\VirtualAccount Wallet object returned from API
     */
    public function Create($walletId, $idempotencyKey = null)
    {
        return $this->CreateObject('virtual_account_create', $walletId, '\MangoPay\VirtualAccount', null, null, $idempotencyKey);
    }

    /**
     * @param string $walletId
     * @param string $virtualAccountId
     * @return \MangoPay\VirtualAccount
     */
    public function Get($walletId, $virtualAccountId)
    {
        return $this->GetObject('virtual_account_get', '\MangoPay\VirtualAccount', $walletId, $virtualAccountId);
    }

    /**
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param string $walletId
     * @return \MangoPay\VirtualAccount[]
     */
    public function GetAll($walletId)
    {
        return $this->GetList('virtual_account_get_all', $pagination, '\MangoPay\VirtualAccount', $walletId);
    }

    public function Deactivate($walletId, $idempotencyKey = null)
    {
    }

    public function GetAvailabilities($walletId, $idempotencyKey = null)
    {
    }
}