<?php
namespace MangoPay;

/**
 * Filter for dispute list
 */
class FilterDisputes extends FilterBase
{

    /**
     * DisputeType {CONTESTABLE, NOT_CONTESTABLE, RETRIEVAL}
     * @var string
     */
    public $DisputeType;

    /**
     * DisputeStatus {CREATED, PENDING_CLIENT_ACTION, SUBMITTED, PENDING_BANK_ACTION,
     * REOPENED_PENDING_CLIENT_ACTION, CLOSED}
     * @var string
     */
    public $Status;
}
