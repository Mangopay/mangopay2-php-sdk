<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class PayInRecurringRegistrationUpdate extends Dto
{
    /**
     * Recurring PayIn's id to update
     * @var string
     */
    public $Id;

    /**
     * @var string
     */
    public $CardId;

    /**
     * @var Shipping
     */
    public $Shipping;

    /**
     * @var Billing
     */
    public $Billing;

    /**
     * @var string
     */
    public $Status;
}
