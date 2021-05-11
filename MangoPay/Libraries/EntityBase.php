<?php

namespace MangoPay\Libraries;

/**
 * Abstract class with common properties
 */
abstract class EntityBase extends Dto
{
    /**
     * @var string Unique identifier
     *
     * At this moment, identifier is a numeric string - in the future, will be GUID.
     */
    public $Id;

    /**
     * @var string Custom data
     */
    public $Tag;

    /**
     * @var int Unix timestamp, Date of creation
     */
    public $CreationDate;

    /**
     * Construct
     * @param string $id Entity identifier
     */
    public function __construct($id = null)
    {
        $this->Id = $id;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        return [ 'Id', 'CreationDate' ];
    }
}
