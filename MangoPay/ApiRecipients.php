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
}
