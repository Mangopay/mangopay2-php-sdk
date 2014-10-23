<?php
namespace MangoPay;

 /**
 * Base filter object
 */
class FilterBase extends Dto {
    /**
     * Start date in unix format:
     * return only records that have CreationDate BEFORE this date
     * @var time
     */
    public $BeforeDate;
    
    /**
     * End date in unix format:
     * return only records that have CreationDate AFTER this date
     * @var time 
     */
    public $AfterDate;
    
    /**
     * Sort option:
     * return records ordered by CreationDate
     * reference http://docs.mangopay.com/api-references/pagination/
     * @var direction
     */
    public $Sort;
}
