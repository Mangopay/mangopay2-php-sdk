<?php
namespace MangoPay\Entities;

use MangoPay\Types;

/**
 * Event entity
 */
class Event extends Types\Dto {

    /**
     * Resource ID
     * @var string
     */
    public $ResourceId;

    /**
     * Event type
     * @var \MangoPay\Enums\EventType
     */
    public $EventType;

    /**
     * Date of event
     * @var Date
     */
    public $Date;
}
