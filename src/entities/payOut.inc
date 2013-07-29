<?php
namespace MangoPay;

/**
 * PayOut entity
 */
class PayOut extends Transaction {
    
    /**
     * Debited wallet Id
     * @var int 
     */
    public $DebitedWalletId;
    
    /**
     * MeanOfPaymentType (BANK_WIRE, MERCHANT_EXPENSE, AMAZON_GIFTCARD)
     * @var string  
     */
    protected $MeanOfPaymentType;
    
    /**
     * One of PayOutPaymentDetails implementations, depending on $MeanOfPaymentType
     * @var object 
     */
    public $MeanOfPaymentDetails;
    
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    public function GetDependsObjects() {
        return array(
            'MeanOfPaymentType' => array(
                '_property_name' => 'MeanOfPaymentDetails',
                'BANK_WIRE' => '\MangoPay\PayOutPaymentDetailsBankWire',
                // ...and more in future...
            )
        );
    }
}