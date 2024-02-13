<?php

namespace MangoPay;

class PaymentMethodMetadata extends Libraries\EntityBase
{
    /**
     * The type of metadata. Allowed values: BIN, GOOGLE_PAY
     * @var string
     */
    public $Type;

    /**
     * The bank identification number (BIN). (Format: 6 or 8 digits)
     * @var string
     */
    public $Bin;

    /**
     * The tokenized payment data provided by the third-party payment method.
     * @var string
     */
    public $Token;

    /**
     * In the case of Google Pay, the format of the Token.
     * PAN_ONLY – The card is registered in the Google account and requires 3DS authentication.
     * CRYPTOGRAM_3DS – The card is enrolled in the customer’s Google Wallet and authentication is handled by the Android device.
     * @var string
     */
    public $TokenFormat;

    /**
     * The type of the card. Allowed / Returned / Default values: CREDIT, DEBIT, CHARGE CARD
     * @var string
     */
    public $CardType;

    /**
     * The country where the card was issued. Format: ISO-3166 alpha-2 two-letter country code
     * @var string
     *
     */
    public $IssuerCountryCode;

    /**
     * The name of the card issuer.
     * @var string
     */
    public $IssuingBank;

    /**
     * Whether the card is held in a personal or commercial capacity.
     * @var string
     */
    public $CommercialIndicator;

    /**
     * Additional data about the card based on the BIN. In the case of co-branded card products, two objects are returned.
     * @var array
     */
    public $BinData;
}
