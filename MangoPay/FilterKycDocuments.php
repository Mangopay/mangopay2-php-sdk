<?php

namespace MangoPay;

/**
 * Filter for dispute document list
 */
class FilterKycDocuments extends FilterBase
{
    /**
     * @var string
     * @see \MangoPay\KycDocumentStatus
     */
    public $Status;

    /**
     * @var string
     * @see \MangoPay\KycDocumentType
     */
    public $Type;
}
