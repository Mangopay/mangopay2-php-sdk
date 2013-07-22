<?php
namespace MangoPay;

/**
 * Know your customer request entity for natural user
 */
class KYCRequestNatural extends KYCRequest {
    
    /**
     * File with proof of identity
     * @var File 
     */
    public $ProofOfIdentity;
    
    /**
     * File with proof of address
     * @var File 
     */
    public $ProofOfAddress;
}