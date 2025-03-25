<?php

namespace MangoPay;

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
}
