<?php

namespace MangoPay;

class VirtualAccountAddress extends Libraries\Dto
{
    /**
     * @var string
     */
    public $StreetName;

    /**
     * @var string
     */
    public $PostCode;

    /**
     * @var string
     */
    public $TownName;

    /**
     * @var string
     */
    public $CountrySubDivision;

    /**
     * @var string
     */
    public $Country;
}
