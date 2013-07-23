<?php
namespace MangoPay;

/**
 * Transfer entity
 */
class Transfer extends PayObject {
    
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