<?php

namespace MangoPay\Libraries;

/**
 * Class represents error object
 */
class Error
{
    /**
     * Error message
     * @var String
     * @access public
     */
    public $Message;
        
    /**
     * Array with errors information
     * @var KeyValueArray
     * @access public
     */
    public $Errors;
    
    /**
     * Return the stdClass error serialized as string
     * @access public 
     */
    public function __toString()
    {
        return serialize($this->Errors);
    }
}
