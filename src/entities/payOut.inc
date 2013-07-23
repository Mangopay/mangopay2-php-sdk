<?php
namespace MangoPay;

/**
 * PayOut entity
 */
class PayOut extends PayObject {
    
    /**
     * Debited wallet Id
     * @var int 
     */
    public $DebitedWalletId;
    
    /**
     * Type of payment
     * @var string  
     */
    protected $MeanOfPaymentType;
    
    /**
     * Payment object
     * @var object 
     */
    public $MeanOfPayment;
    
    
    /**
     * Get array with mapping which property depends on other property  
     * @return array
     */
    protected function GetDependsObjects() {
        return array(
            'MeanOfPaymentType' => array(
                '_property_name' => 'MeanOfPayment',
                'BANK_WIRE' => '\MangoPay\BankWirePayOut',
                'MERCHANT_EXPENSE' => '\MangoPay\MerchantExpense',
                'AMAZON_GIFTCARD' => '\MangoPay\AmazonGiftCard'
            )
        );
    }
}