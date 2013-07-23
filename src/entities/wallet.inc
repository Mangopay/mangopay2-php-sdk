<?php
namespace MangoPay;

/**
 * Wallet entity
 */
class Wallet extends EntityBase {
    
    /**
     * Array with owners identites
     * @var array 
     */
    public $Owners;
    
    /**
     * Wallet description
     * @var string 
     */
    public $Description;
    
    /**
     * Money in wallet
     * @var Money 
     */
    protected $Balance;
    
    /**
     * Currency code in ISO
     * @var string
     */
    public $Currency;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    protected function GetSubObjects() {
        return array( 'Balance' => '\MangoPay\Money' );
    }
}
