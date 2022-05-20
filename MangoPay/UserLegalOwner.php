<?php

namespace MangoPay;

/**
 * UserLegalOwner entity
 */
class UserLegalOwner extends UserLegalPayer
{
    /**
     *
     * @var Address
     */
    public $HeadquartersAddress;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeEmail;

    /**
     *
     * @var int Unix timestamp
     */
    public $LegalRepresentativeBirthday;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeNationality;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeCountryOfResidence;

    /**
     *
     * @var string
     */
    public $LegalRepresentativeProofOfIdentity;

    /**
     *
     * @var string
     */
    public $Statute;

    /**
     *
     * @var string
     */
    public $ProofOfRegistration;

    /**
     *
     * @var string
     */
    public $ShareholderDeclaration;

    /**
     * @var string
     */
    public $CompanyNumber;

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

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Statute');
        array_push($properties, 'ProofOfRegistration');
        array_push($properties, 'ShareholderDeclaration');

        return $properties;
    }
}