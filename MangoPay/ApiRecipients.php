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
}
