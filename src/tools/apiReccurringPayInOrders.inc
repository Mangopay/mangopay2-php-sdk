<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for reccurring pay-in orders
 */
class ApiReccurringPayInOrders extends ApiBase {
    
    /**
     * Create reccurring pay-in order
     * @param \MangoPay\RecurringPayInOrder $reccurringPayInOrder MangoPay\RecurringPayInOrder object to create
     * @return \MangoPay\RecurringPayInOrder Recurring pay-in order object returned from API
     */
    public function Create($reccurringPayInOrder) {
        return $this->CreateObject('reccurringpayinorders_create', $reccurringPayInOrder, '\MangoPay\RecurringPayInOrder');
    }
    
    /**
     * Get reccurring pay-in order object
     * @param type $reccurringPayInOrderId ReccurringPayInOrder identifier
     * @return \MangoPay\RecurringPayInOrder MangoPay\RecurringPayInOrder object returned from API
     */
    public function Get($reccurringPayInOrderId) {
        return $this->GetObject('reccurringpayinorders_get', $reccurringPayInOrderId, '\MangoPay\RecurringPayInOrder');
    }
    
    /**
     * Get list of executions of a recurring payment
     * @param type $reccurringPayInOrderId ReccurringPayInOrder identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return \MangoPay\Transaction MangoPay\Transaction objects returned from API
     */
    public function Transactions($reccurringPayInOrderId, & $pagination = null) {
        return $this->GetList('reccurringpayinorders_gettransactions', $pagination, '\MangoPay\Transaction', $reccurringPayInOrderId);
    }
}