<?php
namespace MangoPay;

/**
 * Repudiation entity
 */
class Repudiation extends PayObject {
    
    public $InitialTransactionId;
    public $InitialTransacitonType;
    public $DebitedWalletId;
    public $CreditedWalletId;
}