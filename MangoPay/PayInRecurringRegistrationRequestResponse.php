<?php

namespace MangoPay;

class PayInRecurringRegistrationRequestResponse extends PayInRecurringRegistration
{
    /**
     * @var string
     */
    public $Id;

    /**
     * @var string
     */
    public $Status;

    /**
     * @var string
     */
    public $RecurringType;

    /**
     * @var int
     */
    public $TotalAmount;

    /**
     * @var int
     */
    public $CycleNumber;

    /**
     * @var int
     */
    public $FreeCycles;
}
