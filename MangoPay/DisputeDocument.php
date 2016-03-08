<?php
namespace MangoPay;

/**
 * Dispute document entity
 */
class DisputeDocument extends Libraries\Document
{
    
    /**
     * Type of dispute document
     * @var \MangoPay\DisputeDocumentType
     */
    public $Type;
    
    /**
     * Status of dispute document
     * @var \MangoPay\DisputeDocumentStatus
     */
    public $Status;
}
