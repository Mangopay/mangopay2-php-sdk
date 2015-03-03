<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for cards
 */
class ApiEvents extends ApiBase {

    /**
     * Get events
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\FilterEvents $filter Object to filter data
     * @return \MangoPay\Entities\Event[] Events list
     */
    public function GetAll(& $pagination = null, $filter = null) {
        return $this->GetList('events_all', $pagination, '\MangoPay\Entities\Event', null, $filter);
    }
}
