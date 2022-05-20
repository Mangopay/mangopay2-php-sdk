<?php

namespace MangoPay;

class UserLegalPayer extends Libraries\EntityBase
{
    /**
     * Type of user
     * @var string
     */
    public $PersonType;

    /**
     * Type for legal user. Possible: ‘BUSINESS’, ’ORGANIZATION’
     * @var string
     */
    public $LegalPersonType;

    /**
     * Name of user
     * @var string
     */
    public $Name;

    /**
     *
     * @var Address
     */
    public $LegalRepresentativeAddress;

    /**
     * User category: Payer or Owner
     * @var string
     */
    public $UserCategory;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeFirstName;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeLastName;

    /**
     * User's email
     * @var string
     */
    public $Email;

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
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'TermsAndConditionsAcceptedDate');

        return $properties;
    }

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['LegalRepresentativeAddress'] = '\MangoPay\Address';

        return $subObjects;
    }
}
