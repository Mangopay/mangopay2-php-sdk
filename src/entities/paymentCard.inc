<?php
namespace MangoPay;

/**
 * Payment cards entity
 */
class PaymentCard extends EntityBase {
    
    /**
     * Alias for payment card
     * @var string 
     */
    protected $Alias;
    
    /**
     * Status for payment card. Possible: ENABLED, DISABLED
     * @var string 
     */
    protected $Status;
    
    /**
     * Type for payment card. Example: VISA, MASTERCARD, ...
     * @var string 
     */
    protected $Type;
    
    /**
     * Date of expiration for payment card
     * @var date 
     */
    protected $ExpirationDate;
    
    /**
     * Name of bank for payment card
     * @var string 
     */
    protected $Bank;
    
    /**
     * Country for payment card
     * @var string 
     */
    protected $Country;
    
}
