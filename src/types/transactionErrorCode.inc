<?php

namespace MangoPay;

/**
 * Class represents code and message with transaction error
 */
class TransactionErrorCode {
    
    /**
     * Code of error
     * @var Int
     * @access public
     */
    public $Code;
    
    /**
     * Message of error
     * @var String
     * @access public
     */
    public $Message;
    
    /**
     * 
     * @var Bool
     * @access public
     */
    public $IsRetryable;
}
