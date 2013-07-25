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
     * @todo TEMP??? Prop renamed from Currency to CurrencyDto in the API??? Still have it in tests!!!
     */
    //public $Currency;
    public $CurrencyDto;
    public function __get($name) { if ($name == 'Currency') return $this->CurrencyDto; else return parent::__get($name); }
    public function __set($name, $value) { if ($name == 'Currency') $this->CurrencyDto = $value; else parent::__set($name, $value); }
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    protected function GetSubObjects() {
        return array( 'Balance' => '\MangoPay\Money' );
    }
}
