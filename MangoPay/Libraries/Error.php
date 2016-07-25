<?php

namespace MangoPay\Libraries;

/**
 * Class represents error object
 */
class Error
{
    /**
     * Error message
     * @var string
     * @access public
     */
    public $Message;
        
    /**
     * Array with errors information
     * @var array
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
