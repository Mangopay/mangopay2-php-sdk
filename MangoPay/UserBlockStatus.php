<?php

namespace MangoPay;

class UserBlockStatus extends Libraries\EntityBase
{
    /**
     * @var ScopeBlocked
     */
    public $ScopeBlocked;

    /**
     * @var string
     */
    public $ActionCode;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ScopeBlocked'] = '\MangoPay\ScopeBlocked';

        return $subObjects;
    }
}
