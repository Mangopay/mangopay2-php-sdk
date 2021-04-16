<?php

namespace MangoPay;

/**
 * Transaction entity.
 * Base class for: PayIn, PayOut, Transfer.
 */
class Transaction extends Libraries\EntityBase
{
    /**
     * Author Id
     * @var string
     */
    public $AuthorId;

    /**
     * Credited user Id
     * @var string
     */
    public $CreditedUserId;

    /**
     * Debited funds
     * @var \MangoPay\Money
     */
    public $DebitedFunds;

    /**
     * Credited funds
     * @var \MangoPay\Money
     */
    public $CreditedFunds;

    /**
     * Fees
     * @var \MangoPay\Money
     */
    public $Fees;

    /**
     * @var string
     * @see \MangoPay\TransactionStatus
     */
    public $Status;

    /**
     * Result code
     * @var string
     */
    public $ResultCode;

    /**
     * The PreAuthorization result Message explaining the result code
     * @var string
     */
    public $ResultMessage;

    /**
     * Execution date
     * @var int
     */
    public $ExecutionDate;

    /**
     * @var string
     * @see \MangoPay\TransactionType
     */
    public $Type;

    /**
     * @var string
     * @see \MangoPay\TransactionNature
     */
    public $Nature;

    /**
     * Debited wallet Id
     * @var string
     */
    public $DebitedWalletId;

    /**
     * Credited wallet Id
     * @var string
     */
    public $CreditedWalletId;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        return [
            'DebitedFunds' => '\MangoPay\Money' ,
            'CreditedFunds' => '\MangoPay\Money' ,
            'Fees' => '\MangoPay\Money'
        ];
    }

    /**
     * Get array with read-only properties
     * @return array
     */
    public function GetReadOnlyProperties()
    {
        $properties = parent::GetReadOnlyProperties();
        array_push($properties, 'Status');
        array_push($properties, 'ResultCode');
        array_push($properties, 'ExecutionDate');

        return $properties;
    }
}
