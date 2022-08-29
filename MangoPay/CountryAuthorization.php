<?php

namespace MangoPay;

/**
 * Repudiation entity
 */
class CountryAuthorization extends Libraries\EntityBase
{
    /**
     * The code of the country in the ISO 3166-1 alpha-2 format.
     * @var string
     */
    public $CountryCode;

    /**
     * Name of the country
     * @var string
     */
    public $CountryName;

    /**
     * Information about the country’s restrictions.
     * @var CountryAuthorizationData
     */
    public $Authorization;

    /**
     * Date and time when at least one of the authorizations has been last updated.
     * @var string
     */
    public $LastUpdate;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'Authorization' => '\MangoPay\CountryAuthorizationData'
        ];
    }
}
