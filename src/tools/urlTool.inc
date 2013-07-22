<?php
namespace MangoPay;

class UrlTool {
    
    public $timestamp;
    
    function __construct() {
        $this->timestamp = time();
    }    
    
    private function GetHost(){
        
        if (!defined('MangoPay_BaseUrl'))
            throw new Exception ('Constant MangoPay_BaseUrl is not defined');
        
        $baseUrl = MangoPay_BaseUrl;
        if (strpos($baseUrl, '/', strlen($baseUrl) - 1 ))
             $baseUrl = substr ($baseUrl, 0, strlen($baseUrl) - 1);  
        
        return $baseUrl;
    }
    
    public function GetRestUrl($urlKey, $addClientId = true, $pagination = null) {
        
        if (!$addClientId) {
            
            $url = '/v2' . $urlKey;
            return $url;
            
        } else {
            
            $url = '/v2/' . MangoPay_ClientID . $urlKey;
            
            if (!is_null($pagination)) {
                $url .= '?page=' . $pagination->Page . '&per_page=' . $pagination->ItemsPerPage;
            }
            
            return $url;
        }
    }
    
    public function GetFullUrl($restUrl) {
        return $this->GetHost() . $restUrl;
    } 
}
