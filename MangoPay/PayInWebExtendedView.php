<?php

namespace MangoPay;

/**
 * Pay-in entity
 */
class PayInWebExtendedView extends Libraries\Dto
{
    /**
     * The PayIn's ID
     * @var string
     */
    public $Id;

    /**
     * Payment Type
     * @var string
     */
    public $PaymentType;

    /**
     * ExecutionType { WEB, TOKEN, DIRECT, PREAUTHORIZED, RECURRING_ORDER_EXECUTION }
     * @var string
     */
    public $ExecutionType;

    /**
     * The expiry date of the credit card (MMYY)
     * @var string
     */
    public $ExpirationDate;

    /**
     * A partially obfuscated version of the credit card number
     * @var object
     */
    public $Alias;

    /**
     * The card type
     * @var string
     */
    public $CardType;

    /**
     * Country of the address
     * @var string
     */
    public $Country;

    /**
     * Card's fingerprint hash, unique per 16-digit card number
     * @var string
     */
    public $Fingerprint;
}
