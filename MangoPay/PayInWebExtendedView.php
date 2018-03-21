<?php
namespace MangoPay;

/**
 * Pay-in entity
 */
class PayInWebExtendedView
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
     * Time when the transaction happened
     * @var int
     */
    public $ExecutionDate;

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
}
