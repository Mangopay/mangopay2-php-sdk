<?php

namespace MangoPay;

class InstantConversion extends Libraries\EntityBase
{
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
     * The sell funds
     * @var Money
     */
    public $DebitedFunds;


    /**
     * The buy funds
     * @var Money
     */
    public $CreditedFunds;

    /**
     * Real time indicative market rate of a specific currency pair
     * @var ConversionRate
     */
    public $ConversionRate;

    /**
     * The status of the transaction.
     * @var string
     * @see \MangoPay\TransactionStatus
     */
    public $Status;

    /**
     * The type of transaction
     * @var string
     * @see \MangoPay\TransactionType
     */
    public $Type;

    /**
     * The nature of the transaction, providing more
     * information about the context in which the transaction occurred:
     * @var string
     * @see \MangoPay\TransactionNature
     */
    public $Nature;

    /**
     * The code indicates the result of the operation.
     * This information is mostly used to handle errors or for filtering purposes.
     * @var string
     */
    public $ResultCode;

    /**
     * The explanation of the result code.
     * @var string
     */
    public $ResultMessage;

    /**
     * The date and time at which the status changed to SUCCEEDED,
     * indicating that the transaction occurred.
     * The statuses CREATED and FAILED return an ExecutionDate of null
     * @var int
     */
    public $ExecutionDate;
}
