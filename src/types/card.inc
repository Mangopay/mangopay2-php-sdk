<?php
namespace MangoPay;

/**
 * Class represents Card type for mean of payment in PayIn entity
 */
class Card {
    /**
     * Type of card
     * @var string 
     */
    public $CardType;
    
    /**
     * Redirect URL
     * @var string
     */
    protected $RedirectURL;
    
    /**
     * Return URL
     * @var string 
     */
    public $ReturnURL;
}
