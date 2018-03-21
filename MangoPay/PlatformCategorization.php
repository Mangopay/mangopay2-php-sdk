<?php
namespace MangoPay;

/**
 * Class holds details about the client platform categorization
 */
class PlatformCategorization extends Libraries\Dto
{

    /**
     * Type of business conducted by the platform
     * @var string (see \MangoPay\BusinessType)
     */
    public $BusinessType;

    /**
     * Sector of business in which the platform operates
     * @var string (see \MangoPay\Sector)
     */
    public $Sector;
}