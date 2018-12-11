<?php
namespace MangoPay;

/**
 * Class represents Web type for 'DIRECT' execution option in PayIn entity
 */
class PayInExecutionDetailsDirect extends Libraries\Dto implements PayInExecutionDetails
{
    /**
     * SecureMode { DEFAULT, FORCE }
     * @var string
     */
    public $SecureMode;

    /**
     * SecureModeReturnURL
     * @var string
     */
    public $SecureModeReturnURL;

    /**
     * SecureModeRedirectURL
     * @var string
     */
    public $SecureModeRedirectURL;

     /**
     * SecureModeNeeded
     * @var bool
     */
    public $SecureModeNeeded;

    /**
     * Billing information
     * @var \MangoPay\Billing
     */
    public $Billing;

    /**
     * Security & validation information
     * @var \MangoPay\SecurityInfo
     */
    public $SecurityInfo;

    /**
     * The language to use for the payment page - needs to be the ISO code of the language
     * @var string
     */
    public $Culture;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['SecurityInfo'] = '\MangoPay\SecurityInfo';
    }
}
