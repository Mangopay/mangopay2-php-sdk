<?php
namespace MangoPay;

/**
 * Transfer entity
 */
class Transfer extends Transaction {
    
    /**
     * Debited wallet Id
     * @var int  
     */
    public $DebitedWalletID;
    
    /**
     * Credited wallet Id
     * @var int  
     */
    public $CreditedWalletID;
}