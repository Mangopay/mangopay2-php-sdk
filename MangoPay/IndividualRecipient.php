<?php

namespace MangoPay;

class IndividualRecipient extends Libraries\Dto
{
    /**
     * The first name of the individual recipient.
     * @var string
     */
    public $FirstName;

    /**
     * The last name of the individual recipient.
     * @var string
     */
    public $LastName;

    /**
     * The address of the individual recipient.
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
