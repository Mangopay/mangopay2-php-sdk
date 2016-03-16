<?php
namespace MangoPay;

/**
 * Client entity
 */
class Client extends Libraries\Dto
{
    /**
     * Client identifier
     * 
     * @var String
     */
    public $ClientId;
    
    /**
     * Name of client
     * 
     * @var String
     */
    public $Name;
    
    /**
     * Email of client
     * 
     * @var String
     */
    public $Email;
    
    /**
     * Password for client
     * 
     * @var String
     */
    public $Passphrase;
    
    /**
     * Branding colour to use for theme pages.
     * Must be a valid HEX including the #
     * 
     * @var String
     */
    public $PrimaryThemeColour;
    
    /**
     * Branding colour to use for call to action buttons.
     * Must be a valid HEX including the #
     * 
     * @var String
     */
    public $PrimaryButtonColour;
    
    /**
     * The URL for MANGOPAY hosted logo
     * 
     * @var String
     */
    public $Logo;
    
    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'ClientId');
        array_push($properties, 'Name');
        array_push($properties, 'Email');
        array_push($properties, 'Passphrase');
        array_push($properties, 'Logo');
        return $properties;
    }
}
