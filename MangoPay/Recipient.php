<?php

namespace MangoPay;

/**
 * Recipient entity
 */
class Recipient extends Libraries\EntityBase
{
    /**
     * The status
     * @var string
     */
    public $Status;

    /**
     * A unique external identifier for the recipient's bank account.
     * @var string
     */
    public $DisplayName;

    /**
     * Defines the payout method (e.g., LocalBankTransfer, InternationalBankTransfer).
     * @var string
     */
    public $PayoutMethodType;

    /**
     * Specifies whether the recipient is an Individual or a Business.
     * @var string
     */
    public $RecipientType;

    /**
     * 3-letter ISO 4217 destination currency code (e.g. EUR, USD, GBP, AUD, CAD,HKD, SGD, MXN).
     * @var string
     */
    public $Currency;

    /**
     * Individual recipient
     * @var IndividualRecipient
     */
    public $IndividualRecipient;

    /**
     * Business recipient
     * @var BusinessRecipient
     */
    public $BusinessRecipient;

    /**
     * Each currency has specific bank details that must be provided based on the recipient's location and payout requirements.
     * @var array<string, mixed>
     */
    public $LocalBankTransfer;

    /**
     * Information about the action required from the user
     * @var PendingUserAction
     */
    public $PendingUserAction;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['IndividualRecipient'] = '\MangoPay\IndividualRecipient';
        $subObjects['BusinessRecipient'] = '\MangoPay\BusinessRecipient';
        $subObjects['PendingUserAction'] = '\MangoPay\PendingUserAction';

        return $subObjects;
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        return $properties;
    }
}
