<?php

namespace MangoPay;

/**
 * Information about the items bought by the customer
 */
class LineItem extends Libraries\Dto
{
    /**
     * Item name
     * @var string
     */
    public $Name;

    /**
     * Quantity of item bought
     * @var int
     */
    public $Quantity;

    /**
     * The item cost
     * @var int
     */
    public $UnitAmount;

    /**
     * The item tax
     * @var int
     */
    public $TaxAmount;

    /**
     * A consistent and unique reference for the seller. It can be:
        - The user ID created on MANGOPAY for the seller
        - Or the firstname and lastname of the seller
     * @var string
     */
    public $Description;

    /**
     * @var string
     */
    public $Category;
}
