<?php

namespace MangoPay;

/**
 * Class represents transaction result code
 */
class TransactionResultCode {
    
    /**
     * Type of transaction
     * @var String
     * @access public
     */
    public $TransactionType;
        
    /**
     * Code of error
     * @var Int
     * @access public
     */
    public $ErrorCode;
    
    
    /**
     * Code with details information
     * @var String
     * @access public
     */
    public $DetailsCode;
    
}
