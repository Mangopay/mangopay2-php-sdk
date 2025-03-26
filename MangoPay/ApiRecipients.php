<?php

namespace MangoPay;

use MangoPay\Libraries\Exception;

/**
 * Class to management MangoPay API for recipients
 */
class ApiRecipients extends Libraries\ApiBase
{
    /**
     * Create new recipient
     * @param Recipient $recipient
     * @param string $userId
     * @return Recipient Recipient object returned from API
     */
    public function Create($recipient, $userId, $idempotencyKey = null)
    {
        return $this->CreateObject('recipients_create', $recipient, '\MangoPay\Recipient', $userId, null, $idempotencyKey);
    }

    /**
     * Get a recipient
     * @param string $recipientId
     * @return Recipient Recipient object returned from API
     * @throws Exception
     */
    public function Get($recipientId)
    {
        return $this->GetObject('recipients_get', '\MangoPay\Recipient', $recipientId);
    }

    /**
     * Get all recipients associated with a specific user
     * @param string $userId
     * @param Pagination $pagination
     * @return Recipient[] Array of Recipient
     * @throws Exception
     */
    public function GetUserRecipients($userId, $pagination = null)
    {
        return $this->GetList('recipients_get_all', $pagination,  '\MangoPay\Recipient', $userId);
    }

    /**
     * See payout methods available to your platform by currency and country
     * @param string $country The destination country of the payout method.
     * @param string $currency The currency of the payout method.
     * @return PayoutMethods
     * @throws Exception
     */
    public function GetPayoutMethods($country, $currency)
    {
        return $this->GetObject('recipient_get_payout_methods', '\MangoPay\PayoutMethods', $country, $currency);
    }

    /**
     * Get a Recipient schema
     * @param string $payoutMethodType Defines the payout method (e.g., LocalBankTransfer, InternationalBankTransfer).
     * @param string $recipientType Specifies whether the recipient is an Individual or a Business.
     * @param string $currency 3-letter ISO 4217 destination currency code (e.g. EUR, USD, GBP, AUD, CAD,HKD, SGD, MXN).
     * @return RecipientSchema
     * @throws Exception
     */
    public function GetSchema($payoutMethodType, $recipientType, $currency)
    {
        return $this->GetObject('recipient_get_schema', '\MangoPay\RecipientSchema', $payoutMethodType, $recipientType, $currency);
    }
}
