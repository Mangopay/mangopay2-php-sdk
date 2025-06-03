<?php

namespace MangoPay;

/**
 * Filter for reports list. To be used when fetching a list of Reports
 */
class FilterReportsV2 extends FilterBase
{
    /**
     * Possible values: PENDING, GENERATING, GENERATED, EXPIRED, FAILED
     * @var string
     */
    public $Status;

    /**
     * The date and time after which the report’s transaction was created, based on the transaction’s CreationDate.
     * @var int
     */
    public $AfterDate;

    /**
     * The date and time before which the report’s transaction was created, based on the transaction’s CreationDate.
     * @var int
     */
    public $BeforeDate;
}
