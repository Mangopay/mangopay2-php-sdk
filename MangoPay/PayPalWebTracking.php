<?php

namespace MangoPay;

class PayPalWebTracking extends Libraries\Dto
{
    /**
     * Item name
     * @var string
     */
    public $TrackingNumber;

    /**
     * Quantity of item bought
     * @var string
     */
    public $Carrier;

    /**
     * The item cost
     * @var bool
     */
    public $NotifyBuyer;
}
