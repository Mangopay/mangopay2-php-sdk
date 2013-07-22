<?php
namespace MangoPay;

/**
 * Know your customer request entity
 */
class KYCRequest extends EntityBase {
    
    /**
     * Status of KYC Request. Possible values: CREATED, SUCCEEDED or FAILED
     * @var string 
     */
    protected $Status;
    
    /**
     * Date of review
     * @var Date 
     */
    protected $ReviewDate;
    
    /**
     * Review message
     * @var string 
     */
    protected $ReviewMessage;
}