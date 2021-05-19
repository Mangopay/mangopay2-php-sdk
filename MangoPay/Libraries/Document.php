<?php

namespace MangoPay\Libraries;

/**
 * Abstract class for all documents
 */
abstract class Document extends EntityBase
{
    /**
     * Refused reason type
     * @var string
     */
    public $RefusedReasonType;

    /**
     * Refused reason message
     * @var string
     */
    public $RefusedReasonMessage;

    /**
     * Date when this document was processed
     * @var int Unix timestamp
     */
    public $ProcessedDate;

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'RefusedReasonType');
        array_push($properties, 'RefusedReasonMessage');
        array_push($properties, 'UserId');

        return $properties;
    }
}
