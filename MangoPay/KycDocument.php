<?php
namespace MangoPay;

/**
 * KYC document entity
 */
class KycDocument extends Libraries\Document
{
    /**
     * Document type
     * @var string (See \MangoPay\KycDocumentType)
     */
    public $Type;
    
    /**
     * Document status
     * @var string (See \MangoPay\KycDocumentStatus)
     */
    public $Status;
    
    /**
     * User identifier
     * @var string
     */
    public $UserId;
}
