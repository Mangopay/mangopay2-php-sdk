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

    public function CanBeNull()
    {
        return $this->IsEmpty($this->FirstName)
            && $this->IsEmpty($this->LastName)
            && $this->IsEmpty($this->ProofOfIdentity)
            && $this->IsEmpty($this->Email)
            && $this->IsEmpty($this->Birthday)
            && $this->IsEmpty($this->Nationality)
            && $this->IsEmpty($this->CountryOfResidence)
            && $this->IsEmpty($this->PhoneNumber)
            && $this->IsEmpty($this->PhoneNumberCountry);
    }

    private function IsEmpty($value)
    {
        return is_null($value) || empty($value);
    }
}
