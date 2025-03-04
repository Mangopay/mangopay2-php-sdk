<?php

namespace MangoPay;

class LegalRepresentative extends Libraries\Dto
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
     * @var string
     */
    public $ProofOfIdentity;

    /**
     * @var string
     */
    public $Email;

    /**
     * @var int Unix timestamp
     */
    public $Birthday;

    /**
     * @var string
     */
    public $Nationality;

    /**
     * @var string
     */
    public $CountryOfResidence;

    /**
     * @var string
     */
    public $PhoneNumber;

    /**
     * @var string
     */
    public $PhoneNumberCountry;
}
