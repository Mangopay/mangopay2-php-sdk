<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for hooks
 */
class ApiHooks extends ApiBase {
    
    /**
     * Create callback URL
     * @param \MangoPay\Hook $hook MangoPay\Hook object to create
     * @return \MangoPay\Hook Wallet object returned from API
     */
    public function Create($hook) {
        return $this->CreateObject('hooks_create', $hook, '\MangoPay\Hook');
    }
    
    /**
     * Get callback URL
     * @param type $hookId Hook identifier
     * @return \MangoPay\Hook MangoPay\Hook object returned from API
     */
    public function Get($hookId) {
        return $this->GetObject('hooks_get', $hookId, '\MangoPay\Hook');
    }
    
    /**
     * Save callback URL
     * @param \MangoPay\Hook $hook MangoPay\Hook object to save
     * @return \MangoPay\Hook MangoPay\Hook object returned from API
     */
    public function Save($hook) {
        return $this->SaveObject('hooks_save', $hook, '\MangoPay\Hook');
    }
    
    /**
     * Get list of callback URLs
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with \MangoPay\Hook objects returned from API
     */
    public function All(& $pagination = null) {
        return $this->GetList('hooks_all', $pagination, '\MangoPay\Hook');
    }
}