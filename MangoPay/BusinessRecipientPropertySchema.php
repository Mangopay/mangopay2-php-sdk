<?php

namespace MangoPay;

class BusinessRecipientPropertySchema extends Libraries\Dto
{
    /**
     * @var RecipientPropertySchema
     */
    public $BusinessName;

    /**
     * @var RecipientAddressPropertySchema
     */
    public $Address;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['BusinessName'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Address'] = '\MangoPay\RecipientAddressPropertySchema';

        return $subObjects;
    }
}
