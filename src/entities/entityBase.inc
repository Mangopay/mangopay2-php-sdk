<?php

namespace MangoPay;

/**
 * Abstract class with common properties
 */
abstract class EntityBase {
    
    /**
     * @var Int Unique identifier
     * (At this moment type is Integer - in the feature will be GUID)
     */
    protected $Id;
    
    /**
     * @var String Custom data
     */
    public $Tag;
    
    /**
     * @var Time Date of creation
     */
    protected $CreationDate;
    
    /**
     * Construct
     * @param type $id Entity identifier
     */
    function __construct($id = null) {
        $this->Id = $id;
    }
    
    /**
     * Magic function to set all properties as public for getting value
     * @param string $name
     * @return mixed
     */
    public function __get($name) {
        if (property_exists($this, $name))
            return $this->$name;
        
        throw new Exception('Property ' . $name . ' in class ' . get_class($this) . ' not exist');
    }
    
    /**
     * Magic function to throw exception if try set not public property
     * @param string $name
     * @param string $value
     * @throws MagicPay\Exception If try set not public property
     */
    public function __set($name, $value) {
        throw new Exception('Property ' . $name . ' not exist or it is read-only');
    }
}
