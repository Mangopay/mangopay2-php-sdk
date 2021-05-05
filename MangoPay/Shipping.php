<?php

namespace MangoPay;

class Shipping extends Libraries\Dto
{
    /**
     * The First Name for Billing Address
     * @var string
     */
    public $FirstName;

    /**
     * The Last Name for Billing Address
     * @var string
     */
    public $LastName;

    /**
     * The address.
     * @var Address
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
