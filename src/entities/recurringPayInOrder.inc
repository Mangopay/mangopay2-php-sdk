<?php
namespace MangoPay;

/**
 * Recurring pay-in order entity
 */
class RecurringPayInOrder extends EntityBase {
    
    public $AuthorId;
    public $DebitedFunds;
    public $CreditedFunds;
    public $Fees;
    public $CreditedWalletID;
    public $ResultCode;
    public $IsEnabled;
    public $Status;
    public $StartDate;
    public $Frequency;
    public $NumberOfExecutions;
    public $MeanOfPaymentType;
    public $ExecutionType;
    public $MeanOfPaymentOptions;
    public $ExecutionOptions;
}