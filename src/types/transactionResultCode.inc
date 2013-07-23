<?php
namespace MangoPay;

/**
 * Class represents transaction result code
 */
class TransactionResultCode {
    
    /**
     * Type of transaction
     * @var String
     */
    public $TransactionType;
        
    /**
     * Type of error
     * @var Int
     */
    public $ErrorType;
    
    /**
     * Code with details information
     * @var int
     */
    public $ErrorDetails;
    
    /**
     * Constructor
     * @param string $resultCode Result code as string
     */
    function __construct($resultCode = '') {
        
        if (isset($resultCode)) {
            $this->TransactionType = substr($resultCode, 0, 2);
            $this->ErrorType = substr($resultCode, 2, 2);
            $this->ErrorDetails = substr($resultCode, 4, 3);
        }
    }
}
