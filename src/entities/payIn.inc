<?php
namespace MangoPay;

/**
 * Pay-in entity
 */
class PayIn extends EntityBase {
    
    public $CreditedWalletId;
    public $EMOwnerId;
    
    protected $MeanOfPaymentType;
    public $MeanOfPayment;
    
    protected $ExecutionType;
    public $Execution;
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    protected function GetDependsObjects() {
        return array(
            'MeanOfPaymentType' => array(
                '_type' => 'depend',
                '_property_name' => 'MeanOfPayment',
                'CARD' => 'MangoPay\Card',
                'REGISTERED_CARD' => 'MangoPay\RegisteredCard',
                'BANK_WIRE' => 'MangoPay\BankWirePayIn',
                // 'DIRECT_DEBIT' => 'MangoPay\',
                'DIRECT_CREDIT' => 'MangoPay\DirectCredit'
            ),
            'ExecutionType' => array(
                '_type' => 'depend',
                '_property_name' => 'Execution',
                'WEB' => 'MangoPay\Web',
                'DIRECT' => 'MangoPay\Direct',
                'PREAUTHORIZED' => 'MangoPay\Preauthorized',
                'RECURRING_ORDER_EXECUTION' => 'MangoPay\RecurrentExecution'
            )
        );
    }
}
