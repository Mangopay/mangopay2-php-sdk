<?php

namespace MangoPay;

class Ubo extends Libraries\EntityBase
{
    /**
     * @var string
     */
    public $FirstName;

    /**
     * @var string
     */
    public $LastName;

    /**
     * @var Address
     */
    public $Address;

    /**
     * @var string
     */
    public $Nationality;

    /**
     * @var int
     */
    public $Birthday;

    /**
     * @var Birthplace
     */
    public $Birthplace;

    /**
     * @var bool
     */
    public $isActive;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['Address'] = '\MangoPay\Address';
        $subObjects['Birthplace'] = '\MangoPay\Birthplace';

        return $subObjects;
    }
}
