<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for pay-ins
 */
class ApiPayIns extends Libraries\ApiBase
{
    /**
     * Create new pay-in object
     * @param \MangoPay\PayIn $payIn \MangoPay\PayIn object
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Create($payIn, $idempotencyKey = null)
    {
        $paymentKey = $this->GetPaymentKey($payIn);
        $executionKey = $this->GetExecutionKey($payIn);
        return $this->CreateObject('payins_' . $paymentKey . '-' . $executionKey . '_create', $payIn, '\MangoPay\PayIn', null, null, $idempotencyKey);
    }

    /**
     * Get pay-in object
     * @param string $payInId Pay-in identifier
     * @return \MangoPay\PayIn Object returned from API
     */
    public function Get($payInId)
    {
        return $this->GetObject('payins_get', '\MangoPay\PayIn', $payInId);
    }

    /**
     * Create refund for pay-in object
     * @param string $payInId Pay-in identifier
     * @param \MangoPay\Refund $refund Refund object to create
     * @return \MangoPay\Refund Object returned by REST API
     */
    public function CreateRefund($payInId, $refund, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_createrefunds', $refund, '\MangoPay\Refund', $payInId, null, $idempotencyKey);
    }

    /**
     * Create a recurring payment
     * @param \MangoPay\PayInRecurringRegistration $recurringRegistration
     * @return \MangoPay\PayInRecurringRegistrationRequestResponse
     */
    public function CreateRecurringRegistration($recurringRegistration, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_registration', $recurringRegistration, '\MangoPay\PayInRecurringRegistrationRequestResponse', null, $idempotencyKey);
    }

    /**
     * Get recurring payment
     * @param string $recurringRegistrationId
     * @return \MangoPay\PayInRecurringRegistrationGet
     */
    public function GetRecurringRegistration($recurringRegistrationId, $idempotencyKey = null)
    {
        return $this->GetObject('payins_recurring_registration_get', '\MangoPay\PayInRecurringRegistrationGet', $recurringRegistrationId);
    }

    /**
    * Update recurring payment
    * @param PayInRecurringRegistrationUpdate $recurringUpdate
    * @return \MangoPay\PayInRecurringRegistrationGet
    */
    public function UpdateRecurringRegistration($recurringUpdate, $idempotencyKey = null)
    {
        return $this->SaveObject('payins_recurring_registration_put', $recurringUpdate, '\MangoPay\PayInRecurringRegistrationGet');
    }

    /**
     * Create a Recurring PayIn CIT
     * @param \MangoPay\RecurringPayInCIT $recurringPayInRegistrationCIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayInRegistrationCIT($recurringPayInRegistrationCIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_card_direct', $recurringPayInRegistrationCIT, '\MangoPay\PayInRecurring', null, $idempotencyKey);
    }

    /**
     * Create a Recurring PayIn MIT
     * @param \MangoPay\RecurringPayInMIT $recurringPayInRegistrationMIT
     * @return \MangoPay\PayInRecurring
     */
    public function CreateRecurringPayInRegistrationMIT($recurringPayInRegistrationMIT, $idempotencyKey = null)
    {
        return $this->CreateObject('payins_recurring_card_direct', $recurringPayInRegistrationMIT, '\MangoPay\PayInRecurring', null, $idempotencyKey);
    }

    /**
     * Retrieves a list of Refunds pertaining to a certain PayIn
     * @param string $payInId ID of PayIn for which to retrieve Refunds
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterRefunds $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\Refund[] List of the PayIn's Refunds
     */
    public function GetRefunds($payInId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('refunds_get_for_payin', $pagination, '\MangoPay\Refund', $payInId, $filter, $sorting);
    }

    private function GetPaymentKey($payIn)
    {
        if (!isset($payIn->PaymentDetails) || !is_object($payIn->PaymentDetails)) {
            throw new Libraries\Exception('PaymentDetails is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\PayInPaymentDetails', '', get_class($payIn->PaymentDetails));
        return strtolower($className);
    }

    private function GetExecutionKey($payIn)
    {
        if (!isset($payIn->ExecutionDetails) || !is_object($payIn->ExecutionDetails)) {
            throw new Libraries\Exception('ExecutionDetails is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\PayInExecutionDetails', '', get_class($payIn->ExecutionDetails));
        return strtolower($className);
    }

    /**
     * Retrieves a more detailed view of details concerning
     * the card used to process a Web payment.
     * @param string $payInId ID of the PayIn to retrieve card details for
     * @return \MangoPay\PayInWebExtendedView Object returned from API
     */
    public function GetExtendedCardView($payInId)
    {
        return $this->GetObject('get_extended_card_view', '\MangoPay\PayInWebExtendedView', $payInId);
    }

    /**
     * Create Card PreAuthorized Deposit PayIn
     * @param CreateCardPreAuthorizedDepositPayIn $payIn PayIn object to create
     * @return PayIn Deposit object returned from API
     */
    public function CreateCardPreAuthorizedDepositPayIn(CreateCardPreAuthorizedDepositPayIn $payIn)
    {
        return $this->CreateObject('payins_create_card_pre_authorized_deposit', $payIn, '\MangoPay\PayIn');
    }
}
