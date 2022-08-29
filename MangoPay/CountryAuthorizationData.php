<?php

namespace MangoPay;

/**
 * Repudiation entity
 */
class CountryAuthorizationData extends Libraries\EntityBase
{
    /**
     * Whether or not user creation is possible based on the user’s country of residence.
     * @var boolean
     */
    public $BlockUserCreation;

    /**
     * Whether or not bank account creation is possible based on the bank’s country of domiciliation.
     * @var boolean
     */
    public $BlockBankAccountCreation;

    /**
     * Whether or not payout creation is possible based on the bank’s country of domiciliation.
     * @var boolean
     */
    public $BlockPayout;
}
