<?php

namespace MangoPay;

/**
 * Pre-authorization payment statuses
 */
class CardPreAuthorizationPaymentStatus
{
    public const Canceled = 'CANCELED';
    public const Expired = 'EXPIRED';
    public const Validated = 'VALIDATED';
    public const Waiting = 'WAITING';
}
