<?php
namespace MangoPay;

/**
 * Class represents Web type for execution option in PayIn entity
 */
class Web {
    /**
     * Template URL
     * @var string 
     */
    public $TemplateURL;
    
    /**
     * Show registered card
     * @var bool 
     */
    public $ShowRegisteredCard;
    
    /**
     * Register card
     * @var bool 
     */
    public $RegisterCard;
    
    /**
     * Culture
     * @var string 
     */
    public $Culture;
    
    /**
     * Mode 3DS
     * @var string 
     */
    public $Mode3DS;
}