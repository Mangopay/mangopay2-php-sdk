<?php
namespace MangoPay;

/**
 * KYC (Know Your Customer) entity
 */
class KYC extends EntityBase {
    /**
     * Level of Know Your Customer. 
     * Value in range: 1-5.
     * @var Int 
     */
    protected $KYCLevel;
    
    /**
     * Cash in limit
     * @var Int 
     */
    protected $CashinLimit;
    
    /**
     * Cash in remaining
     * @var Int 
     */
    protected $CashInRemaining;
}