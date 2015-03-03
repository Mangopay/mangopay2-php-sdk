<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for hooks and notifications
 */
class ApiHooks extends ApiBase {

    /**
     * Create new hook
     * @param Hook $hook
     * @return \MangoPay\Entities\Hook Hook object returned from API
     */
    public function Create($hook) {
        return $this->CreateObject('hooks_create', $hook, '\MangoPay\Entities\Hook');
    }

    /**
     * Get hook
     * @param type $hookId Hook identifier
     * @return \MangoPay\Entities\Hook Wallet object returned from API
     */
    public function Get($hookId) {
        return $this->GetObject('hooks_get', $hookId, '\MangoPay\Entities\Hook');
    }

    /**
     * Save hook
     * @param type $hook Hook object to save
     * @return \MangoPay\Entities\Hook Hook object returned from API
     */
    public function Update($hook) {
        return $this->SaveObject('hooks_save', $hook, '\MangoPay\Entities\Hook');
    }

    /**
     * Get all hooks
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return \MangoPay\Entities\Hook[] Array with objects returned from API
     */
    public function GetAll(& $pagination = null) {
        return $this->GetList('hooks_all', $pagination, '\MangoPay\Entities\Hook');
    }
}
