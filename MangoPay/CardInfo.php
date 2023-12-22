<?php

namespace MangoPay;

class CardInfo extends Libraries\Dto
{
    /**
     * The 6-digit bank identification number (BIN) of the card issuer.
     * @var string
     */
    public $BIN;

    /**
     * The name of the card issuer.
     * @var string
     */
    public $IssuingBank;

    /**
     * The country where the card was issued.
     * @var string
     */
    public $IssuerCountryCode;

    /**
     * The type of card product: DEBIT, CREDIT, CHARGE CARD.
     * @var string
     */
    public $Type;

    /**
     * The card brand. Examples include: AMERICAN EXPRESS, DISCOVER, JCB, MASTERCARD, VISA, etc.
     * @var string
     */
    public $Brand;

    /**
     * The subtype of the card product. Examples include: CLASSIC, GOLD, PLATINUM, PREPAID, etc.
     * @var string
     */
    public $SubType;
}
