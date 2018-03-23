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
     * @var string
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

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['Billing'] = '\MangoPay\Billing';
        $subObjects['SecurityInfo'] = '\MangoPay\SecurityInfo';
    }
}
