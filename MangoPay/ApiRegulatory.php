<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for regulatory endpoints
 */
class ApiRegulatory extends Libraries\ApiBase
{
    /**
     * Get country authorizations by country code
     * @param string $countryCode
     * @return \MangoPay\CountryAuthorization
     * @throws Libraries\Exception
     */
    public function GetCountryAuthorizations($countryCode)
    {
        return $this->GetObject('country_authorization_get', '\MangoPay\CountryAuthorization', $countryCode, null, null, false);
    }

    /**
     * Get all countries authorizations
     * @param \MangoPay\Pagination $pagination
     * @param \MangoPay\Sorting $sorting
     * @return \MangoPay\CountryAuthorization[]
     * @throws Libraries\Exception
     */
    public function GetAllCountryAuthorizations(& $pagination = null, $sorting = null)
    {
        return $this->GetList('country_authorization_all', $pagination, 'MangoPay\CountryAuthorization', null, null, $sorting, null, false);
    }
}
