<?php

namespace MangoPay;

class PayInIntentSeller extends Libraries\Dto
{
    /**
     * The unique identifier of the seller providing the item
     *
     * One valid value must be sent between AuthorId & WalletId
     * @var string
     */
    public $AuthorId;

    /**
     * The unique identifier of the wallet to credit the seller funds
     *
     * One valid value must be sent between AuthorId & WalletId
     * @var string
     */
    public $WalletId;

    /**
     * Information about the fees
     * @var int
     */
    public $FeesAmount;

    /**
     * Information about the date when the funds are to be transferred to the seller’s wallet
     *
     * Must be a date in the future
     * @var string
     */
    public $TransferDate;
}
