<?php

namespace MangoPay;

class BusinessRecipient extends Libraries\Dto
{
    /**
     * The name of the business
     * @var string
     */
    public $BusinessName;

    /**
     * Contains the business address details
     * @var Address
     */
    public $Address;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['Address'] = '\MangoPay\Address';

        return $subObjects;
    }
}
