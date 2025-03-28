<?php

namespace MangoPay;

class RecipientAddressPropertySchema extends Libraries\Dto
{
    /**
     * @var RecipientPropertySchema
     */
    public $AddressLine1;

    /**
     * @var RecipientPropertySchema
     */
    public $AddressLine2;

    /**
     * @var RecipientPropertySchema
     */
    public $City;

    /**
     * @var RecipientPropertySchema
     */
    public $Region;

    /**
     * @var RecipientPropertySchema
     */
    public $PostalCode;

    /**
     * @var RecipientPropertySchema
     */
    public $Country;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['AddressLine1'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['AddressLine2'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['City'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Region'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['PostalCode'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Country'] = '\MangoPay\RecipientPropertySchema';

        return $subObjects;
    }
}
