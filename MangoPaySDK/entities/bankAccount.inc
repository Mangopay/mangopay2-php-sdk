<?php
namespace MangoPay;

/**
 * Bank Account entity
 */
class BankAccount extends EntityBase {
    
    /**
     * User identifier
     * @var LeetchiId 
     */
    protected $UserId;
    
    /**
     * Type of bank account
     * @var string 
     */
    public $Type;
    
    /**
     * Owner name
     * @var string 
     */
    public $OwnerName;
    
    /**
     * Owner address
     * @var string 
     */
    public $OwnerAddress;
    
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
