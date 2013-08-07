<?php

namespace MangoPay;

/**
 * Abstract class for all DTOs (entities and their composites)
 */
abstract class Dto {
    
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

    /**
     * Get array with mapping which property is object and what type of object.
     * To be overridden in child class if has any sub objects.
     * @return array
     */
    public function GetSubObjects() { return array(); }

    /**
     * Get array with mapping which property depends on other property  
     * To be overridden in child class if has any dependent objects.
     * @return array
     */
    public function GetDependsObjects() { return array(); }
}
