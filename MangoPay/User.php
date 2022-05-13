<?php

namespace MangoPay;

/**
 * User entity
 */
abstract class User extends Libraries\EntityBase
{
    /**
     * Type of user
     * @var string
     */
    public $PersonType;

    /**
     * Email address
     * @var string
     */
    public $Email;

    /**
     * KYC Level (LIGHT or REGULAR)
     * @var string
     */
    public $KYCLevel;

    /**
     * Whether the user has accepted the MANGOPAY Terms and Conditions.
     * @var bool
     */
    public $TermsAndConditionsAccepted;

    /**
     * The date on which the user has accepted the MANGOPAY Terms and Conditions.
     * @var int
     */
    public $TermsAndConditionsAcceptedDate;

    /**
     * Category of user
     * @var string
     */
    public $UserCategory;

    /**
     * Construct
     * @param string $personType string with type of person
     */
    protected function SetPersonType($personType)
    {
        $this->PersonType = $personType;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'PersonType', 'TermsAndConditionsAcceptedDate');

        return $properties;
    }
}
