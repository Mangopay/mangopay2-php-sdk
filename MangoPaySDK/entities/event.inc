<?php
namespace MangoPay;

/**
 * Event entity
 */
class Event extends Dto {
    
    /**
     * Ressource ID
     * @var string 
     */
    public $ResourceId;
    
    /**
     * Event type
     * @var \MangoPay\EventType 
     */
    public $EventType;
        
    /**
     * Date of event
     * @var Date 
     */
    public $Date;
}