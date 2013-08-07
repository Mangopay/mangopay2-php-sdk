<?php
namespace MangoPay;

/**
 * Transaction entity.
 * Base class for: PayIn, PayOut, Transfer.
 */
class Transaction extends EntityBase {
    
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
     * @var \MangoPay\Money
     */
    public $DebitedFunds;
    
    /**
     * Credited funds
     * @var \MangoPay\Money
     */
    public $CreditedFunds;
    
    /**
     * Fees
     * @var \MangoPay\Money
     */
    public $Fees;
    
    /**
     * TransactionStatus {CREATED, SUCCEEDED, FAILED}
     * @var string 
     */
    protected $Status;
    
    /**
     * Result code
     * @var string
     */
    protected $ResultCode;
    
    /**
     * Execution date;
     * @var date
     */
    protected $ExecutionDate;
    
    /**
     * TransactionType {PAYIN, PAYOUT, TRANSFER}
     * @var string
     */
    public $Type;
    
    /**
     * TransactionNature { REGULAR, REFUND, REPUDIATION }
     * @var string
     */
    public $Nature;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects() {
        return array(
            'DebitedFunds' => '\MangoPay\Money' ,
            'CreditedFunds' => '\MangoPay\Money' ,
            'Fees' => '\MangoPay\Money'
        );
    }
}
