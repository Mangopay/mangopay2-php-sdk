<?php
namespace MangoPay;

/**
 * Refund entity
 */
class Refund extends Transaction {
    
    /**
     * Initial transaction Id
     * @var int
     */
    public $InitialTransactionId;
    
    /**
     * Debited wallet Id
     * @var int  
     */
    public $DebitedWalletId;
    
    /**
     * Credited wallet Id
     * @var int  
     */
    public $CreditedWalletId;
}

