<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

/**
 * A conversion, at the rate guaranteed by its quote, of the debited funds to the credited wallet.
 */
class CreateQuotedConversion extends Dto
{
    /**
     * The unique identifier of the active quote which guaranteed the rate for the conversion.
     * @var string
     */
    public $QuoteId;

    /**
     * The unique identifier of the user at the source of the transaction.
     * @var string
     */
    public $AuthorId;

    /**
     * The unique identifier of the debited wallet.
     * @var string
     */
    public $DebitedWalletId;

    /**
     * The unique identifier of the credited wallet
     * @var string
     */
    public $CreditedWalletId;

    /**
     * Custom data.
     * @var string
     */
    public $Tag;
}
