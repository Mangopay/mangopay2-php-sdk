<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class CreateInstantConversion extends Dto
{

    /**
     * The unique identifier of the user at the source of the transaction.
     * @var string
     */
    var $AuthorId;

    /**
     * The unique identifier of the debited wallet
     *
     * @var string
     */
    var $DebitedWalletId;

    /**
     * The unique identifier of the credited wallet
     * @var string
     */
    var $CreditedWalletId;

    /**
     * The sell funds
     * @var Money
     */
    var $DebitedFunds;

    /**
     * The buy funds
     * @var Money
     */
    var $CreditedFunds;

    /**
     * Information about the fees taken by the platform for this transaction (and hence transferred to the Fees Wallet).
     * @var Money
     */
    var $Fees;

    /**
     * Custom data.
     * @var string
     */
    var $Tag;

}