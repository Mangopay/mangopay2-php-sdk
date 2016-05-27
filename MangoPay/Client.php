<?php
namespace MangoPay;

/**
 * Client entity
 */
class Client extends Libraries\EntityBase
{
    /**
     * Client identifier
     * @var string
     */
    public $ClientId;
    
    /**
     * Name of client
     * @var string
     */
    public $Name;
    
    /**
     * Email of client
     * @var string
     */
    public $Email;
    
    /**
     * Password for client
     * @var string
     */
    public $Passphrase;
}
