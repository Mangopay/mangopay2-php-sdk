<?php
namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterTransactions extends Dto {
    
    /**
     * TransactionStatus {CREATED, SUCCEEDED, FAILED}
     * @var string  
     */
    public $Status;
    
    /**
     * TransactionType {PAY_IN, PAY_OUT, TRANSFER}
     * @var string 
     */
    public $Type;
    
    /**
     * TransactionNature { NORMAL, REFUND, REPUDIATION }
     * @var string
     */
    public $Nature;
    
    /**
     * TransactionDirection {DEBIT, CREDIT}
     * @var string 
     */
    public $Direction;
    
    /**
     * Start date in unix format:
     * return only transactions that have CreationDate BEFORE this date
     * @var time 
     */
    public $BeforeDate;
    
    /**
     * End date in unix format:
     * return only transactions that have CreationDate AFTER this date
     * @var time 
     */
    public $AfterDate;
}