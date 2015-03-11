<?php
namespace MangoPay;

/**
 * Refund entity
 */
class Refund extends Transaction {
    
    /**
     * Initial transaction Id
     * @var string
     */
    public $InitialTransactionId;

    /**
     * Initial transaction Type {PAYIN, PAYOUT, TRANSFER}
     * @var string
     */
    public $InitialTransactionType;
    
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
}
