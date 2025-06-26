<?php

namespace MangoPay\Libraries;

class UrlTool
{
    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    private $_root;

    /**
     * Constructor
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @param \MangoPay\MangoPayApi $root
     */
    public function __construct($root)
    {
        $this->_root = $root;
    }

    private function GetHost()
    {
        if (is_null($this->_root->Config->BaseUrl) || strlen($this->_root->Config->BaseUrl) == 0) {
            throw new Exception('Neither MangoPay_BaseUrl constant nor BaseUrl config setting is defined.');
        }

        $baseUrl = $this->_root->Config->BaseUrl;
        if (strpos($baseUrl, '/', strlen($baseUrl) - 1)) {
            $baseUrl = substr($baseUrl, 0, strlen($baseUrl) - 1);
        }

        return $baseUrl;
    }

    public function GetRestUrl($urlPath, $apiVersion, $addClientId = true, $pagination = null, $additionalUrlParams = null)
    {
        if (!$addClientId) {
            $url = '/' . $apiVersion . $urlPath;
        } else {
            $url = '/' . $apiVersion . '/' . $this->_root->Config->ClientId . $urlPath;
        }

        $paramsAdded = false;
        if (!is_null($pagination)) {
            $url .= '?page=' . $pagination->Page . '&per_page=' . $pagination->ItemsPerPage;
            $paramsAdded = true;
        }

        if (!is_null($additionalUrlParams)) {
            if (array_key_exists("sort", $additionalUrlParams)) {
                $url .= $paramsAdded ? '&' : '?';
                $url .= http_build_query($additionalUrlParams["sort"]);
                $paramsAdded = true;
            }

            if (array_key_exists("filter", $additionalUrlParams)) {
                $url .= $paramsAdded ? '&' : '?';
                $url .= http_build_query($additionalUrlParams["filter"]);
                $paramsAdded = true;
            }
        }

        return $url;
    }

    public function GetFullUrl($restUrl)
    {
        return $this->GetHost() . $restUrl;
    }
}
