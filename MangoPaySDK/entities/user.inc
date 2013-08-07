<?php

namespace MangoPay;

/**
 * User entity
 */
abstract class User extends EntityBase {
    
    /**
     * Type of user
     * @var String
     */
    protected $PersonType;
    
    /**
     * Email address
     * @var String 
     */
    public $Email;
    
    /**
     * Construct
     * @param string $personType String with type of person
     */
    protected function setPersonType($personType) {
        $this->PersonType = $personType;
    }
}