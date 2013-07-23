<?php
namespace MangoPay;

/**
 * Abstract class to pay's objects
 */
abstract class PayObject extends EntityBase {
    
    /**
     * Author Id
     * @var int 
     */
    public $AuthorId;
    
    /**
     * Credited user Id
     * @var int 
     */
    public $CreditedUserId;
    
    /**
     * Debited funds
     * @var MangoPay\Money 
     */
    public $DebitedFunds;
    
    /**
     * Credited funds
     * @var MangoPay\Money 
     */
    public $CreditedFunds;
    
    /**
     * Fees
     * @var MangoPay\Money 
     */
    public $Fees;
    
    /**
     * Status, values: CREATED, SUCCEEDED, FAILED
     * @var string 
     */
    public $Status;
    
    /**
     * Result code object
     * @var MangoPay\TransactionResultCode 
     */
    public $ResultCode;
    
    /**
     * Execution date;
     * @var date 
     */
    public $ExecutionDate;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    protected function GetSubObjects() {
        return array(
            'ResultCode' => '\MangoPay\TransactionResultCode', 
            'DebitedFunds' => '\MangoPay\Money' ,
            'CreditedFunds' => 'MangoPay\Money' ,
            'Fees' => 'MangoPay\Money'
        );
    }
}