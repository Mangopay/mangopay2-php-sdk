<?php

namespace MangoPay;

class PayInIntentRefund extends Libraries\Dto
{
    /**
     * Unique identifier.
     * @var string
     */
    public $Id;

    /**
     * The date at which the object was created
     * @var int
     */
    public $CreationDate;

    /**
     * The date at which the object was successfully moved to REFUNDED
     * @var int
     */
    public $ExecutionDate;

    /**
     * The refund amount
     * @var int
     */
    public $Amount;

    /**
     * The status of the refund
     * @var string
     */
    public $Status;

    /**
     * Information about the items captured in the transaction.
     * @var PayInIntentLineItem[]
     */
    public $LineItems;
}