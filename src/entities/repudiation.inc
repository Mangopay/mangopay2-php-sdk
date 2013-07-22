<?php
namespace MangoPay;

/**
 * Repudiation entity
 */
class Repudiation extends EntityBase {
    
    public $DebitedFunds;
    public $CreditedFunds;
    public $Fees;
    public $InitialTransactionId;
    public $InitialTransacitonType;
    public $DebitedWalletId;
    public $CreditedWalletId;
}