<?php

namespace MangoPay;

/**
 * UserNaturalOwner entity
 */
class UserNaturalOwner extends UserNaturalPayer
{
    /**
     * Date of birth
     * @var int Unix timestamp
     */
    public $Birthday;

    /**
     * User's country
     * @var string
     */
    public $Nationality;

    /**
     * Country of residence
     * @var string
     */
    public $CountryOfResidence;

    /**
     * User's occupation
     * @var string
     */
    public $Occupation;

    /**
     *
     * @var int
     */
    public $IncomeRange;

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