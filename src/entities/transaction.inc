<?php
namespace MangoPay;

/**
 * Transaction entity
 */
class Transaction extends EntityBase {
    
    public $AuthorId;
    public $DebitedFunds;
    protected $CreditedFunds;
    public $Fees;
    protected $Status;
    protected $ResultCode;
    protected $ExecutionDate;
    protected $CreditedWalletID;
    protected $DebitedWalletID;
    protected $Type;
    protected $Type2;
    protected $MeanOfPaymentType;
}
