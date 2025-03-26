<?php

namespace MangoPay;

class IndividualRecipientPropertySchema extends Libraries\Dto
{
    /**
     * @var RecipientPropertySchema
     */
    public $FirstName;

    /**
     * @var RecipientPropertySchema
     */
    public $LastName;

    /**
     * @var RecipientAddressPropertySchema
     */
    public $Address;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['FirstName'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['LastName'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Address'] = '\MangoPay\RecipientAddressPropertySchema';

        return $subObjects;
    }
}
