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
     * @param FilterRecipients $filter
     * @return Recipient[] Array of Recipient
     * @throws Exception
     */
    public function GetUserRecipients($userId, $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('recipients_get_all', $pagination, '\MangoPay\Recipient', $userId, $filter, $sorting);
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
        return $this->GetObject('recipients_get_payout_methods', '\MangoPay\PayoutMethods', $country, $currency);
    }

    /**
     * Get a Recipient schema
     * @param string $payoutMethodType Defines the payout method (e.g., LocalBankTransfer, InternationalBankTransfer).
     * @param string $recipientType Specifies whether the recipient is an Individual or a Business.
     * @param string $currency 3-letter ISO 4217 destination currency code (e.g. EUR, USD, GBP, AUD, CAD,HKD, SGD, MXN).
     * @param string $country Country ISO
     * @return RecipientSchema
     * @throws Exception
     */
    public function GetSchema($payoutMethodType, $recipientType, $currency, $country)
    {
        return $this->GetObjectManyQueryParams(
            'recipients_get_schema',
            '\MangoPay\RecipientSchema',
            $payoutMethodType,
            $recipientType,
            $currency,
            $country
        );
    }

    /**
     * Validate recipient data
     * @param Recipient $recipient
     * @param string $userId
     */
    public function Validate($recipient, $userId, $idempotencyKey = null)
    {
        return $this->CreateObject('recipients_validate', $recipient, null, $userId, null, $idempotencyKey);
    }

    /**
     * Deactivate a Recipient
     * @param string $recipientId
     * @return Recipient Recipient object returned from API
     */
    public function Deactivate($recipientId)
    {
        $dto = new Recipient();
        $dto->Id = $recipientId;
        $dto->Status = 'DEACTIVATED';
        return $this->SaveObject('recipients_deactivate', $dto, '\MangoPay\Recipient');
    }
}
