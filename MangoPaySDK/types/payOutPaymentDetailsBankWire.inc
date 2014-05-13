<?php
namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayOut entity
 */
class PayOutPaymentDetailsBankWire extends Dto implements PayOutPaymentDetails {
    
    /**
     * Bank account Id
     * @var string  
     */
    public $BankAccountId;
}
