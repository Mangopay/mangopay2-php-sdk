<?php
namespace MangoPay;

/**
 * PaymentCardRegistration entity
 */
class PaymentCardRegistration extends EntityBase {
    
    public $AuthorId;
    public $ResultCode;
    public $Status;
    public $MeanOfPayment;
    public $ExecutionType;
    public $MeanOfPaymentOptions;
    public $ExecutionTypeOptions;
    public $CardId;
}