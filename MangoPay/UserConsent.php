<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class UserConsent extends Dto
{
    /**
     * @var PendingUserAction|null
     */
    public $PendingUserAction;

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'PendingUserAction');
        return $properties;
    }

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';

        return $subObjects;
    }
}
