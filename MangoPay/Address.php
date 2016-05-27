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
}
