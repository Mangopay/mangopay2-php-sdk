<?php

namespace MangoPay;

/**
 * Pre-authorization payment statuses
 */
class CardPreAuthorizationPaymentStatus
{
    const Canceled = 'CANCELED';
    const Expired = 'EXPIRED';
    const Validated = 'VALIDATED';
    const Waiting = 'WAITING';
    const CancelRequested = 'CANCEL_REQUESTED';
    const ToBeCompleted = 'TO_BE_COMPLETED';
    const NoShowRequested = 'NO_SHOW_REQUESTED';
    const NoShow = 'NO_SHOW';
    const Failed = 'FAILED';
}
