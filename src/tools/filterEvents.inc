<?php
namespace MangoPay;

/**
 * Filter for events list
 */
class FilterEvents {
    
    /**
     * Start date in unix format 
     * @var time 
     */
    public $Before;
    
    /**
     * End date in unix format 
     * @var time 
     */
    public $After;
    
    /**
     * Resource Id
     * @var string 
     */
    public $ResourceId;
    
    /**
     * Event type
     * @var string 
     */
    public $EventType;
    
}