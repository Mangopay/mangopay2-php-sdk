<?php

namespace MangoPay;

/**
 * Filter for event list
 */
class FilterDisputeDocuments extends FilterBase
{
    /**
     * @var string
     * @see \MangoPay\DisputeDocumentStatus
     */
    public $Status;

    /**
     * @var string
     * @see \MangoPay\DisputeDocumentType
     */
    public $Type;
}
