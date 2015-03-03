<?php
namespace MangoPay\Types;

/**
 * Class represents BankWire type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsBankWire extends Dto implements PayInPaymentDetails {

    /**
     * Declared debited funds
     * @var \MangoPay\Types\Money
     */
    public $DeclaredDebitedFunds;

    /**
     * Declared fees
     * @var \MangoPay\Types\Money
     */
    public $DeclaredFees;

    /**
     * Bank account details
     * @var \MangoPay\Entities\BankAccount
     */
    public $BankAccount;

    /**
     * Wire reference
     * @var string
     */
    public $WireReference;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects() {
        return array(
            'DeclaredDebitedFunds' => '\MangoPay\Types\Money' ,
            'DeclaredFees' => '\MangoPay\Types\Money' ,
            'BankAccount' => '\MangoPay\Entities\BankAccount'
        );
    }
}
