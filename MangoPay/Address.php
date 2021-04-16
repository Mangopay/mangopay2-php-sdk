<?php

namespace MangoPay;

/**
 * Class represents an address.
 */
class Address extends Libraries\Dto
{
    /**
     * Address line 1.
     * @var string
     */
    public $AddressLine1;

    /**
     * Address line 2.
     * @var string
     */
    public $AddressLine2;

    /**
     * City.
     * @var string
     */
    public $City;

    /**
     * Region.
     * @var string
     */
    public $Region;

    /**
     * Postal code.
     * @var string
     */
    public $PostalCode;

    /**
     * Country.
     * @var string
     */
    public $Country;

    public function CanBeNull()
    {
        return $this->IsEmpty($this->AddressLine1)
                && $this->IsEmpty($this->AddressLine2)
                && $this->IsEmpty($this->City)
                && $this->IsEmpty($this->Region)
                && $this->IsEmpty($this->PostalCode)
                && $this->IsEmpty($this->Country);
    }

    private function IsEmpty($value)
    {
        return is_null($value) || empty($value);
    }
}
