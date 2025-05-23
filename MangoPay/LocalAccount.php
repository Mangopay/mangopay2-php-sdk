<?php

namespace MangoPay;

class LocalAccount extends Libraries\Dto
{
    /**
     * The account number of the account
     * @var string
     */
    public $AccountNumber;

    /**
     * The sort code of the account.
     * @var string
     */
    public $SortCode;

    /**
     * @var string
     */
    public $Iban;

    /**
     * @var string
     */
    public $Bic;

    /**
     * @var string
     */
    public $AchNumber;

    /**
     * @var string
     */
    public $FedWireNumber;

    /**
     * @var string
     */
    public $AccountType;

    /**
     * @var string
     */
    public $BranchCode;

    /**
     * @var string
     */
    public $InstitutionNumber;
}
