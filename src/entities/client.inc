<?php
namespace MangoPay;

/**
 * Client entity
 */
class Client extends EntityBase {
    
    /**
     * Client identifier
     * @var String 
     */
    public $ClientId;
    
    /**
     * Name of client
     * @var String 
     */
    public $Name;
    
    /**
     * Password for client
     * @var String 
     */
    public $Passphrase;
}
