<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for events
 */
class ApiEvents extends ApiBase {
    
    /**
     * Get list of last events
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return \MangoPay\Event Event entity returned from API object
     */
    public function All(& $pagination = null) {
        return $this->GetList('users_all', $pagination, '\MangoPay\Event');
    }
    
    /**
     * Get list of callback made ​​for an event
     * @param int $eventId Event identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterEvents $filter Object to filter data
     * @return array Array with \MangoPay\Event entities returned from API object
     */
    public function HookCallbacks($eventId, & $pagination = null, $filter = null) {
        return $this->GetList('events_gethookcallbacks', $pagination, '\MangoPay\Event', $eventId, $filter);
    }
}