<?php

namespace MangoPay;

class CompanyNumber extends Libraries\EntityBase
{
    /**
     * Information about the registration number of a legal entity.
     * @var string
     */
    public $CompanyNumber;

    /**
     * The country of the registration of the legal entity, against which the company number format is validated.
     * @var string
     */
    public $CountryCode;

    /**
     * @var bool
     */
    public $IsValid;

    /**
     * Validation rules applied for a given country
     * @var array
     */
    public $ValidationRules;
}
