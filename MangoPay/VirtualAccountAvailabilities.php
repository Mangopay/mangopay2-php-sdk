<?php

namespace MangoPay;

class VirtualAccountAvailabilities extends Libraries\EntityBase
{
    /**
     * * @var VirtualAccountAvailability[]
     */
    public $Collection;

    /**
     * * @var VirtualAccountAvailability[]
     */
    public $UserOwned;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['Collection'] = '\MangoPay\VirtualAccountAvailability';
        $subObjects['UserOwned'] = '\MangoPay\VirtualAccountAvailability';

        return $subObjects;
    }
}