<?php
namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterTransactions {
    
    /**
     * Status. Possible values: CREATED, SUCCEEDED, FAILED
     * @var string  
     */
    public $Status;
    
    /**
     * Direction. Possible values: DEBIT, CREDIT
     * @var string 
     */
    public $Direction;
    
    /**
     * Direction. Possible values: PAYIN, TRANSFER, PAYOUT
     * @var string 
     */
    public $Type;
    
    /**
     * Direction. Possible values: NORMAL, REFUND, REPUDIATION
     * @var string 
     */
    public $Type2;
    
    /**
     * Start date in unix format 
     * @var time 
     */
    public $Before;
    
    /**
     * End date in unix format 
     * @var time 
     */
    public $After;
}