<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiDeposits extends Libraries\ApiBase
{
    /**
     * Create Deposit
     * @param CreateDeposit $deposit Deposit object to save
     * @return Deposit Deposit object returned from API
     */
    public function Create(CreateDeposit $deposit)
    {
        return $this->CreateObject('deposits_create', $deposit, '\MangoPay\Deposit');
    }

    /**
     * Get Deposit
     * @param string $depositId Deposit identifier
     * @return Deposit Deposit object returned from API
     */
    public function Get($depositId)
    {
        return $this->GetObject('deposits_get', '\MangoPay\Deposit', $depositId);
    }

    /**
     * Cancel Deposit
     * @param string $depositId Deposit identifier
     * @param CancelDeposit $dto Cancel deposit body
     * @return Deposit Deposit object returned from API
     */
    public function Cancel($depositId, CancelDeposit $dto)
    {
        return $this->SaveObject('deposits_cancel', $dto, '\MangoPay\Deposit', $depositId);
    }
}
