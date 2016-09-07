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
     * An identifer for this API response
     * @var string
     * @access public
     */
    public $Id;
	
	/**
     * The timestamp of this API response
     * @var timestamp
     * @access public
     */
    public $Date;
	
	/**
     * The type of error
     * @var string
     * @access public
     */
    public $Type;
    
    /**
     * Return the stdClass error serialized as string
     * @access public 
     */
    public function __toString()
    {
        return serialize($this->Errors);
    }
}
