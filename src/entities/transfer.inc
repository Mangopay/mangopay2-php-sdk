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
    public $DebitedWalletID;
    
    /**
     * Credited wallet Id
     * @var int  
     */
    public $CreditedWalletID;
    
    /**
     * @todo UNDOCUMENTED
     * @var string
     */
    public $Type;

    /**
     * @todo UNDOCUMENTED
     * @var string
     */
    public $Nature;
}