<?php
namespace MangoPay;

/**
 * Pay-in entity
 */
class PayIn extends Transaction {

    /**
     * Credited wallet Id
     * @var int 
     */
    public $CreditedWalletID;
    
    /**
     * PaymentType {CARD, BANK_WIRE, AUTOMATIC_DEBIT, DIRECT_DEBIT }
     * @var string  
     */
    protected $PaymentType;
    
    /**
     * One of PayInPaymentDetails implementations, depending on $PaymentType
     * @var object 
     */
    public $PaymentDetails;
    
    /**
     * ExecutionType { WEB, TOKEN, DIRECT, PREAUTHORIZED, RECURRING_ORDER_EXECUTION }
     * @var string  
     */
    protected $ExecutionType;
    
    /**
     * One of PayInExecutionDetails implementations, depending on $ExecutionType
     * @var object 
     */
    public $ExecutionDetails;
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    public function GetDependsObjects() {
        return array(
            'PaymentType' => array(
                '_property_name' => 'PaymentDetails',
                'CARD' => '\MangoPay\PayInPaymentDetailsCard',
                // ...and more in future...
            ),
            'ExecutionType' => array(
                '_property_name' => 'ExecutionDetails',
                'WEB' => '\MangoPay\PayInExecutionDetailsWeb',
                // ...and more in future...
            )
        );
    }
}
