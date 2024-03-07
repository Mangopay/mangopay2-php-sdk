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
    var $QuoteId;

    /**
     * The unique identifier of the user at the source of the transaction.
     * @var string
     */
    var $AuthorId;

    /**
     * The unique identifier of the debited wallet.
     * @var string
     */
    var $DebitedWalletId;

    /**
     * The unique identifier of the credited wallet
     * @var string
     */
    var $CreditedWalletId;

    /**
     * Custom data.
     * @var string
     */
    var $Tag;
}