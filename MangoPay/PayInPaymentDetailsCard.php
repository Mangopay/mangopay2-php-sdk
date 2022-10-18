<?php

namespace MangoPay;

/**
 * Class represents Card type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsCard extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * CardType
     * @var string
     * @see \MangoPay\CardType
     */
    public $CardType;

    /**
     * CardId
     * @var string
     */
    public $CardId;

    /**
     * StatementDescriptor
     * @var string
     */
    public $StatementDescriptor;

    /**
     * IpAddress
     * @var string
     */
    public $IpAddress;

    /**
     * BrowserInfo
     * @var BrowserInfo
     */
    public $BrowserInfo;

    /**
     * Shipping
     * @var Shipping
     */
    public $Shipping;
}
