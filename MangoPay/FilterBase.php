<?php
namespace MangoPay;

/**
 * Base filter object
 */
class FilterBase extends Libraries\Dto
{
    /**
     * Start date in unix format:
     * return only records that have CreationDate BEFORE this date
     * @var int Unix timestamp
     */
    public $BeforeDate;
    
    /**
     * End date in unix format:
     * return only records that have CreationDate AFTER this date
     * @var int Unix timestamp
     */
    public $AfterDate;
}
