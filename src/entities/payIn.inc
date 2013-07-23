<?php
namespace MangoPay;

/**
 * Pay-in entity
 */
class PayIn extends PayObject {

    /**
     * Credited wallet Id
     * @var int 
     */
    public $CreditedWalletId;
    
    /**
     * Type of payment
     * @var string  
     */
    protected $PaymentType;
    
    /**
     * Payment object
     * @var object 
     */
    public $Payment;
    
    /**
     * Type of execution
     * @var string  
     */
    protected $ExecutionType;
    
    /**
     * Execution object
     * @var object 
     */
    public $Execution;
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    protected function GetDependsObjects() {
        return array(
            'PaymentType' => array(
                '_property_name' => 'Payment',
                'CARD' => '\MangoPay\Card',
                'REGISTERED_CARD' => '\MangoPay\RegisteredCard',
                'BANK_WIRE' => '\MangoPay\BankWirePayIn',
                // 'DIRECT_DEBIT' => '\MangoPay\',
                'DIRECT_CREDIT' => '\MangoPay\DirectCredit'
            ),
            'ExecutionType' => array(
                '_property_name' => 'Execution',
                'WEB' => '\MangoPay\Web',
                'DIRECT' => '\MangoPay\Direct',
                'PREAUTHORIZED' => '\MangoPay\Preauthorized',
                'RECURRING_ORDER_EXECUTION' => '\MangoPay\RecurrentExecution'
            )
        );
    }
}
