<?php
namespace MangoPay;

/**
 * Bank Account entity
 */
class BankAccount extends Libraries\EntityBase
{
    /**
     * User identifier
     * @var string
     */
    public $UserId;
    
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
     * @var Address 
     */
    public $OwnerAddress;
    
     /**
     * One of BankAccountDetails implementations, depending on $Type
     * @var object
     */
    public $Details;

    /**
     * @var boolean
     */
    public $Active;
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        
        $subObjects['OwnerAddress'] = '\MangoPay\Address';
        
        return $subObjects;
    }
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    public function GetDependsObjects()
    {
        return array(
            'Type' => array(
                '_property_name' => 'Details',
                'IBAN' => '\MangoPay\BankAccountDetailsIBAN',
                'GB' => '\MangoPay\BankAccountDetailsGB',
                'US' => '\MangoPay\BankAccountDetailsUS',
                'CA' => '\MangoPay\BankAccountDetailsCA',
                'OTHER' => '\MangoPay\BankAccountDetailsOTHER',
            )
        );
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'UserId');
        array_push($properties, 'Type');
        return $properties;
    }
}
