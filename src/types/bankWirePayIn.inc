<?php
namespace MangoPay;

/**
 * Class represents BankWire type for mean of payment in PayIn entity
 */
class BankWirePayIn {
    
    protected $Reference;
    public $Comment;
    protected $BankAccountOwner;
    protected $BankAccountBIC;
    protected $BankAccountIBAN;
}
