<?php
namespace MangoPay;

/**
 * Class represents IBAN type for in BankAccount entity
 */
class BankAccountDetailsIBAN extends Dto implements BankAccountDetails {
    
    /**
     * IBAN number 
     * @var string 
     */
    public $IBAN;
    
    /**
     * BIC
     * @var string 
     */
    public $BIC;
}