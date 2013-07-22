<?php
namespace MangoPay;

/**
 * Know your customer request entity for legal user
 */
class KYCRequestLegal extends KYCRequest {
    
    /**
     * File with proof of registration
     * @var File 
     */
    public $ProofOfRegistration;
    
    /**
     * File with statute
     * @var File 
     */
    public $Statute;
    
    /**
     * File with shareholder declaration
     * @var File 
     */
    public $ShareholderDeclaration;
}