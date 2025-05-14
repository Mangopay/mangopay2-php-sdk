<?php

namespace MangoPay;

class RecipientSchema extends Libraries\Dto
{
    /**
     * @var RecipientPropertySchema
     */
    public $DisplayName;

    /**
     * @var RecipientPropertySchema
     */
    public $Currency;

    /**
     * @var RecipientPropertySchema
     */
    public $Country;

    /**
     * @var RecipientPropertySchema
     */
    public $RecipientType;

    /**
     * @var RecipientPropertySchema
     */
    public $PayoutMethodType;

    /**
     * @var RecipientPropertySchema
     */
    public $RecipientScope;

    /**
     * @var RecipientPropertySchema
     */
    public $Tag;

    /**
     * @var array<string, array<string, RecipientPropertySchema>>
     */
    public $LocalBankTransfer;

    /**
     * @var array<string, RecipientPropertySchema>
     */
    public $InternationalBankTransfer;

    /**
     * @var IndividualRecipientPropertySchema
     */
    public $IndividualRecipient;

    /**
     * @var BusinessRecipientPropertySchema
     */
    public $BusinessRecipient;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['DisplayName'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Currency'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['RecipientType'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['PayoutMethodType'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['RecipientScope'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['Tag'] = '\MangoPay\RecipientPropertySchema';
        $subObjects['IndividualRecipient'] = '\MangoPay\IndividualRecipientPropertySchema';
        $subObjects['BusinessRecipient'] = '\MangoPay\BusinessRecipientPropertySchema';

        return $subObjects;
    }
}
