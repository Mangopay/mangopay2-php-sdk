<?php

namespace MangoPay;

class Settlement extends Libraries\EntityBase
{
    /**
     * The unique identifier of the settlement object
     * @var string
     */
    public $SettlementId;

    /**
     * The status of the settlement
     * @var string
     */
    public $Status;

    /**
     * The date at which the settlement was created by the external provider
     * @var string
     */
    public $SettlementDate;

    /**
     * The name of the external provider
     * @var string
     */
    public $ExternalProviderName;

    /**
     * The total amount declared through intent API calls with the following calculation:
     * (Sum of captured intents) - (Sum of refunds amounts) + (Sum of refund reversed amounts) - (Sum of DISPUTED disputes) + (Sum of WON disputes)
     * @var int
     */
    public $DeclaredIntentAmount;

    /**
     * The total fees charged by the external provider
     * @var int
     */
    public $ExternalProcessorFeesAmount;

    /**
     * The total amount due to the platform (to be held in escrow wallet).
     * This amount correspond to the TotalSettlementAmount from the settlement file.
     * A negative amount will result in this parameter being set to zero, indicating no incoming funds to the escrow wallet.
     * @var int
     */
    public $ActualSettlementAmount;

    /**
     * The difference between ActualSettlementAmount and the amount received on the escrow wallet
     * @var int
     */
    public $FundsMissingAmount;
}
