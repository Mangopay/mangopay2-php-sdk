<?php

namespace MangoPay;

/**
 * Class represents Web type for execution option in PayIn entity
 */
class PayInPaymentDetailsPreAuthorized extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The ID of the Preauthorization object
     * @var string
     */
    public $PreauthorizationId;

    /**
     * The unique identifier of the deposit preauthorization. Used for Deposit Preauthorized PayIn.
     * @var string
     */
    public $DepositId;
}
