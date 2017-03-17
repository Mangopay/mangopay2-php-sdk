<?php
namespace MangoPay;

/**
 * EMoney entity
 */
class EMoney extends Libraries\Dto
{
    /**
     * User identifier
     * @var string
     */
    public $UserId;
    
    /**
     * Credited funds
     * @var \MangoPay\Money
     */
    public $CreditedEMoney;
    
    /**
     * Debited funds
     * @var \MangoPay\Money
     */
    public $DebitedEMoney;
    
    
    /**
     * Get array with mapping which property is object and what type of object 
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['CreditedEMoney'] = '\MangoPay\Money';
        $subObjects['DebitedEMoney']  = '\MangoPay\Money';
        
        return $subObjects;
    }
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'UserId');
        array_push($properties, 'CreditedEMoney');
        array_push($properties, 'DebitedEMoney');

        return $properties;
    }
}
