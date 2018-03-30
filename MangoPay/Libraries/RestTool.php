<?php

namespace MangoPay\Libraries;

use Psr\Log\LoggerInterface;

/**
 * Class to prepare HTTP request, call the request and decode the response
 */
class RestTool
{
    const VERSION = '2.8.0';

    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    private $_root;
    /**
     * Variable to flag that in request authentication data are required
     * @var bool
     */
    private $_authRequired;
    /**
     * Array with HTTP header to send with request
     * @var array
     */
    private $_requestHttpHeaders;

    /**
     * Return HTTP header to send with request
     * @return array
     */
    public function GetRequestHeaders()
    {
        return $this->_requestHttpHeaders;
    }

    /**
     * Request type for current request
     * @var RequestType
     */
    private $_requestType;

    /**
     * Return HTTP request method
     * @return RequestType
     */
    public function GetRequestType()
    {
        return $this->_requestType;
    }

    /**
     * Array with data to pass in the request
     * @var array|string
     */
    private $_requestData;

    /**
     * Return HTTP request data
     * @return array|string
     */
    public function GetRequestData()
    {
        return $this->_requestData;
    }

    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * Pagination object
     * @var \MangoPay\Pagination
     */
    private $_pagination;
    /**
     * @var string
     */
    private $_requestUrl;

    /**
     * Return HTTP request url
     * @return string
     */
    public function GetRequestUrl()
    {
        return $this->_requestUrl;
    }

    private static $_JSON_HEADER = 'Content-Type: application/json';

    /**
     * Constructor
     * @param bool $authRequired Variable to flag that in request the authentication data are required
     * @param \MangoPay\MangoPayApi $root Root/parent instance that holds the OAuthToken and Configuration instance
     */
    public function __construct($authRequired = true, $root)
    {
        $this->_authRequired = $authRequired;
        $this->_root = $root;
        $this->logger = $root->getLogger();
    }

    public function AddRequestHttpHeader($httpHeader)
    {
        if (is_null($this->_requestHttpHeaders)) {
            $this->_requestHttpHeaders = array();
        }
        array_push($this->_requestHttpHeaders, $httpHeader);
    }

    /**
     * Call request to MangoPay API
     * @param string $urlMethod Type of method in REST API
     * @param \MangoPay\Libraries\RequestType $requestType Type of request
     * @param array $requestData Data to send in request
     * @param string $idempotencyKey
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param array $additionalUrlParams with additional parameters to URL. Expected keys: "sort" and "filter"
     * @return object Response data
     */
    public function Request($urlMethod, $requestType, $requestData = null, $idempotencyKey = null, & $pagination = null, $additionalUrlParams = null)
    {
        $this->_requestType = $requestType;
        $this->_requestData = $requestData;
        if (strpos($urlMethod, 'consult') !== false
            && (strpos($urlMethod, 'KYC/documents') !== false || strpos($urlMethod, 'dispute-documents') !== false)) {
            $this->_requestData = "";
        }
        $logClass = $this->_root->Config->LogClass;
        $this->logger->debug("New request");
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('++++++++++++++++++++++ New request ++++++++++++++++++++++', '');
        }
        $this->BuildRequest($urlMethod, $pagination, $additionalUrlParams, $idempotencyKey);
        $responseResult = $this->_root->getHttpClient()->Request($this);
        $logClass = $this->_root->Config->LogClass;
        $this->logger->debug('Response JSON : ' . print_r($responseResult->Body, true));
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('Response JSON', $responseResult->Body);
        }
        // FIXME This can fail hard.
        $response = json_decode($responseResult->Body);
        $this->logger->debug('Decoded object : ' . print_r($response, true));
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('Response object', $response);
        }
        $this->CheckResponseCode($responseResult->ResponseCode, $response);
        $this->ReadResponseHeader($responseResult->Headers);
        if (!is_null($pagination)) {
            $pagination = $this->_pagination;
        }
        return $response;
    }

    /**
     * Prepare all parameter to request
     *
     * @param string $urlMethod Type of method in REST API
     * @param \MangoPay\Pagination $pagination
     * @param null $additionalUrlParams
     * @param string $idempotencyKey Key for response replication
     */
    private function BuildRequest($urlMethod, $pagination, $additionalUrlParams = null, $idempotencyKey = null)
    {
        $urlTool = new UrlTool($this->_root);
        $restUrl = $urlTool->GetRestUrl($urlMethod, $this->_authRequired, $pagination, $additionalUrlParams);
        $this->_requestUrl = $urlTool->GetFullUrl($restUrl);
        $logClass = $this->_root->Config->LogClass;
        $this->logger->debug('FullUrl : ' . $this->_requestUrl);
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('FullUrl', $this->_requestUrl);
        }
        if (!is_null($pagination)) {
            $this->_pagination = $pagination;
        }
        $this->logger->debug('RequestType : ' . $this->_requestType);
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('RequestType', $this->_requestType);
        }
        $httpHeaders = $this->GetHttpHeaders($idempotencyKey);
        $this->logger->debug('HTTP Headers : ' . print_r($httpHeaders, true));
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('HTTP Headers', $httpHeaders);
        }
        if (!is_null($this->_requestData)) {
            $this->logger->debug('RequestData object :' . print_r($this->_requestData, true));
            if ($this->_root->Config->DebugMode) {
                $logClass::Debug('RequestData object', $this->_requestData);
            }
            // encode to json if needed
            if (in_array(self::$_JSON_HEADER, $httpHeaders)) {
                // FIXME This can also fail hard and is not checked.
                $this->_requestData = json_encode($this->_requestData);
                $this->logger->debug('RequestData JSON :' . print_r($this->_requestData, true));
                if ($this->_root->Config->DebugMode) {
                    $logClass::Debug('RequestData JSON', $this->_requestData);
                }
            }
        }
    }

    /**
     * Read ead response headers
     * @param array $headers Header from response
     */
    private function ReadResponseHeader($headers)
    {
        $logClass = $this->_root->Config->LogClass;
        $this->logger->debug('Response headers :' . print_r($headers, true));
        if ($this->_root->Config->DebugMode) {
            $logClass::Debug('Response headers', print_r($headers, true));
        }
        foreach ($headers as $header) {
            if (strpos($header, 'X-Number-Of-Pages:') !== false) {
                $this->_pagination->TotalPages = (int)trim(str_replace('X-Number-Of-Pages:', '', $header));
            }
            if (strpos($header, 'X-Number-Of-Items:') !== false) {
                $this->_pagination->TotalItems = (int)trim(str_replace('X-Number-Of-Items:', '', $header));
            }
            if (strpos($header, 'Link: ') !== false) {
                $strLinks = trim(str_replace('Link:', '', $header));
                $arrayLinks = explode(',', $strLinks);
                if ($arrayLinks !== false) {
                    $this->_pagination->Links = array();
                    foreach ($arrayLinks as $link) {
                        $tmp = str_replace(array('<"', '">', ' rel="', '"'), '', $link);
                        $oneLink = explode(';', $tmp);
                        if (is_array($oneLink) && isset($oneLink[0]) && isset($oneLink[1])) {
                            $this->_pagination->Links[$oneLink[1]] = $oneLink[0];
                        }
                    }
                }
            }
        }
    }

    /**
     * Get HTTP header to use in request
     * @param string $idempotencyKey Key for response replication
     * @return array Array with HTTP headers
     */
    private function GetHttpHeaders($idempotencyKey = null)
    {
        // return if already created...
        if (!is_null($this->_requestHttpHeaders)) {
            return $this->_requestHttpHeaders;
        }
        // ...or initialize with default headers
        $this->_requestHttpHeaders = array();
        // content type
        array_push($this->_requestHttpHeaders, self::$_JSON_HEADER);
        // Add User-Agent Header
        array_push($this->_requestHttpHeaders, 'User-Agent: MangoPay V2 PHP/' . self::VERSION);
        // Authentication http header
        if ($this->_authRequired) {
            $authHlp = new AuthenticationHelper($this->_root);
            array_push($this->_requestHttpHeaders, $authHlp->GetHttpHeaderKey());
        }
        if ($idempotencyKey != null) {
            array_push($this->_requestHttpHeaders, 'Idempotency-Key: ' . $idempotencyKey);
        }
        return $this->_requestHttpHeaders;
    }

    /**
     * Check response code
     *
     * @param int $responseCode
     * @param object $response Response from REST API
     *
     * @throws ResponseException If response code not OK
     */
    private function CheckResponseCode($responseCode, $response)
    {
        if ($responseCode != 200) {
            if (isset($response) && is_object($response) && isset($response->Message)) {
                $error = new Error();
                $error->Message = $response->Message;
                $error->Errors = property_exists($response, 'Errors')
                    ? $response->Errors
                    : property_exists($response, 'errors') ? $response->errors : null;
                $error->Id = property_exists($response, 'Id') ? $response->Id : null;
                $error->Type = property_exists($response, 'Type') ? $response->Type : null;
                $error->Date = property_exists($response, 'Date') ? $response->Date : null;
                throw new ResponseException($this->_requestUrl, $responseCode, $error);
            } else {
                throw new ResponseException($this->_requestUrl, $responseCode);
            }
        }
    }
}
