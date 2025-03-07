<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class UserEnrollmentResult extends Dto
{
    /**
     * Information about the action required from the user if UserStatus is PENDING_USER_ACTION (otherwise returned null).
     * @var PendingUserAction
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
}
