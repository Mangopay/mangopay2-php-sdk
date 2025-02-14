<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

/**
 * A conversion, at the rate guaranteed by its quote, of the debited funds to the credited wallet.
 */
class CreateClientWalletsQuotedConversion extends Dto
{
    /**
     * The unique identifier of the active quote which guaranteed the rate for the conversion.
     * @var string
     */
    public $QuoteId;

    /**
     * Allowed values: FEES, CREDIT
     *
     * <p>The type of the client wallet to be debited:</p>
     * <p>FEES – Fees Wallet, for fees collected by the platform.</p>
     * <p>CREDIT – Repudiation Wallet, for funds related to dispute management.</p>
     * <p>The amount and currency of the debited funds are defined by the quote.</p>
     * @var string
     */
    public $DebitedWalletType;

    /**
     * Allowed values: FEES, CREDIT
     *
     * <p>The type of the client wallet to be credited:</p>
     * <p>FEES – Fees Wallet, for fees collected by the platform.</p>
     * <p>CREDIT – Repudiation Wallet, for funds related to dispute management.</p>
     * <p>The amount and currency of the credited funds are defined by the quote.</p>
     * @var string
     */
    public $CreditedWalletType;

    /**
     * Custom data.
     * @var string
     */
    public $Tag;
}
