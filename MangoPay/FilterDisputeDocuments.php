<?php
namespace MangoPay;

/**
 * Filter for event list
 */
class FilterDisputeDocuments extends FilterBase
{

    /**
     * DisputeDocumentStatus {CREATED, VALIDATION_ASKED, VALIDATED, REFUSED}
     * @var string
     */
    public $Status;

    /**
     * DisputeDocumentType {DELIVERY_PROOF, INVOICE, REFUND_PROOF, USER_CORRESPONDANCE, USER_ACCEPTANCE_PROOF,
     * PRODUCT_REPLACEMENT_PROOF, OTHER}
     * @var string
     */
    public $Type;
}
