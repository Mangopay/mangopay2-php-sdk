<?php

namespace MangoPay;

/**
 * Report filters. To be used when creating a Report
 */
class ReportFilters extends Libraries\Dto
{
    /**
     * The currency of the wallet(s) being credited or debited by the report’s transactions.
     * @var string
     */
    public $Currency;

    /**
     * The unique identifier of the user owning the wallet(s).
     * @var string
     */
    public $UserId;

    /**
     * The unique identifier of the wallet.
     * @var string
     */
    public $WalletId;
}
