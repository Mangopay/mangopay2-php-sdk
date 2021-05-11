<?php

namespace MangoPay;

/**
 * Information regarding the Apple Pay payment
 */
class PaymentData extends Libraries\Dto
{
    /**
     * ID of the Apple payment transaction
     * @var string
     */
    public $TransactionId;

    /**
     * Network card used for transaction
     * @var string
     */
    public $Network;

    /**
     * Data block containing payment information
     * @var string
     */
    public $TokenData;
}
