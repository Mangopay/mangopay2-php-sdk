<?php
namespace MangoPay;

class UrlTool {
    
    public $timestamp;
    
    function __construct() {
        $this->timestamp = time();
    }    
    
    private function GetHost(){
        
        if (is_null(ApiBase::$Config->BaseUrl) || strlen(ApiBase::$Config->BaseUrl) == 0)
            throw new Exception ('Neither MangoPay_BaseUrl constant nor BaseUrl setting is defined.');
        
        $baseUrl = ApiBase::$Config->BaseUrl;
        if (strpos($baseUrl, '/', strlen($baseUrl) - 1 ))
             $baseUrl = substr ($baseUrl, 0, strlen($baseUrl) - 1);  
        
        return $baseUrl;
    }
    
    public function GetRestUrl($urlKey, $addClientId = true, $pagination = null, $additionalUrlParams = null) {

        if (!$addClientId) {
            $url = '/v2' . $urlKey;
        } else {
            $url = '/v2/' . ApiBase::$Config->ClientId . $urlKey;
        }

        $paramsAdded = false;
        if (!is_null($pagination)) {
            $url .= '?page=' . $pagination->Page . '&per_page=' . $pagination->ItemsPerPage;
            $paramsAdded = true;
        }

        if (!is_null($additionalUrlParams)) {
            $url .= $paramsAdded ? '&' : '?';
            $url .= http_build_query($additionalUrlParams);
            $paramsAdded = true;
        }

        return $url;
    }
    
    public function GetFullUrl($restUrl) {
        return $this->GetHost() . $restUrl;
    } 
}
