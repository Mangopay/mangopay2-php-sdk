<?php

namespace MangoPay;

/**
 * Filter for transaction list
 */
class FilterWallets extends FilterBase
{
    /**
     * @var string
     * Possible values: USER_PRESENT, USER_NOT_PRESENT.
     *
     * In case USER_PRESENT is used and SCA is required, an error containing the RedirectUrl will be thrown
     */
    public $ScaContext;
}
