<?php
namespace MangoPay;

/**
 * KYC document entity
 */
class KycDocument extends Libraries\Document
{
    /**
     * Document type
     * @var \MangoPay\KycDocumentType
     */
    public $Type;
    
    /**
     * Document status
     * @var \MangoPay\KycDocumentStatus
     */
    public $Status;
    
    /**
     * User identifier
     * @var type string
     */
    public $UserId;
}
