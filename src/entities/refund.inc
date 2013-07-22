<?php
namespace MangoPay;

/**
 * Refund entity
 */
class Refund extends EntityBase {
    public $DebitedFunds;
    public $CreditedFunds;
    public $Fees;
    protected $InitialTransactionId;
    protected $InitialTransacitonType;
    protected $DebitedWalletId;
    protected $CreditedWalletId;
}