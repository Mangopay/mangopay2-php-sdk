<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class VerificationOfPayee extends Dto
{
    /**
     * A unique identifier of the VOP check performed by Mangopay.
     * @var string
     */
    public $RecipientVerificationId;

    /**
     * The outcome of the VOP check performed by Mangopay
     * @var string
     */
    public $RecipientVerificationCheck;

    /**
     * The explanation of the check outcome
     * @var string
     */
    public $RecipientVerificationMessage;
}
