<?php
namespace MangoPay;

/**
 * Billing information
 */
class Billing extends Libraries\Dto
{

    /**
     * The billing address
     * @var \MangoPay\Address
     */
    public $Address;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Address'] = '\MangoPay\Address';

        return $subObjects;
    }
}