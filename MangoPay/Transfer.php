<?php

namespace MangoPay;

/**
 * Transfer entity
 */
class Transfer extends Transaction
{
    /**
     * Debited wallet Id
     * @var string
     */
    public $DebitedWalletId;

    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;

    /**
     * @var string
     */
    public $ScaContext;

    /**
     * @var PendingUserAction
     */
    public $PendingUserAction;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';
        return $subObjects;
    }
}
