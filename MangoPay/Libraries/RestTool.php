<?php

namespace MangoPay\Libraries;

use MangoPay\MangoPayApi;
use MangoPay\RateLimit;
use Psr\Log\LoggerInterface;

/**
 * Class to prepare HTTP request, call the request and decode the response
 */
class RestTool
{
    const VERSION = '3.35.1';

    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var MangoPayApi
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
     * Variable to flag if the request path should contain the clientId or not
     * @var bool
     */
    private $_clientIdRequired;

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
     * @param MangoPayApi $root Root/parent instance that holds the OAuthToken and Configuration instance
     * @param bool $authRequired Variable to flag that in request the authentication data are required
     * @param bool $clientIdRequired Variable to flag if the request path should contain the clientId or not
     */
    public function __construct($root, $authRequired = true, $clientIdRequired = true)
    {
        $this->_authRequired = $authRequired;
        $this->_clientIdRequired = $clientIdRequired;
        $this->_root = $root;
        $this->logger = $root->getLogger();
    }

    public function AddRequestHttpHeader($httpHeader)
    {
        if (is_null($this->_requestHttpHeaders)) {
            $this->_requestHttpHeaders = [];
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
        $restUrl = $urlTool->GetRestUrl($urlMethod, $this->_clientIdRequired, $pagination, $additionalUrlParams);
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
                if (!is_null($this->_requestData)) {
                    $this->_requestData = json_encode($this->_requestData);
                    $this->logger->debug('RequestData JSON :' . print_r($this->_requestData, true));
                    if ($this->_root->Config->DebugMode) {
                        $logClass::Debug('RequestData JSON', $this->_requestData);
                    }
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

        $rateLimitReset = [];
        $rateLimitRemaining = [];
        $rateLimitMade = [];

        foreach ($headers as $header) {
            $lowercaseHeader = strtolower($header);
            if (strpos($lowercaseHeader, 'x-number-of-pages:') !== false) {
                $this->_pagination->TotalPages = (int)trim(str_replace('x-number-of-pages:', '', $lowercaseHeader));
            }
            if (strpos($lowercaseHeader, 'x-number-of-items:') !== false) {
                $this->_pagination->TotalItems = (int)trim(str_replace('x-number-of-items:', '', $lowercaseHeader));
            }
            if (strpos($header, 'Link: ') !== false) {
                $strLinks = trim(str_replace('Link:', '', $header));
                $arrayLinks = explode(',', $strLinks);
                if ($arrayLinks !== false) {
                    $this->_pagination->Links = [];
                    foreach ($arrayLinks as $link) {
                        $tmp = str_replace(['<"', '">', ' rel="', '"'], '', $link);
                        $oneLink = explode(';', $tmp);
                        if (is_array($oneLink) && isset($oneLink[0]) && isset($oneLink[1])) {
                            $this->_pagination->Links[$oneLink[1]] = $oneLink[0];
                        }
                    }
                }
            }

            if (strpos($lowercaseHeader, 'x-ratelimit-remaining:') !== false) {
                $value = (int)trim(str_replace('x-ratelimit-remaining:', '', $lowercaseHeader));
                $rateLimitRemaining[] = $value;
            }

            if (strpos($lowercaseHeader, 'x-ratelimit:') !== false) {
                $value = (int)trim(str_replace('x-ratelimit:', '', $lowercaseHeader));
                $rateLimitMade[] = $value;
            }

            if (strpos($lowercaseHeader, 'x-ratelimit-reset:') !== false) {
                $value = (int)trim(str_replace('x-ratelimit-reset:', '', $lowercaseHeader));
                $rateLimitReset[] = $value;
            }
        }

        if (sizeof($rateLimitReset) == sizeof($rateLimitRemaining) && sizeof($rateLimitReset) == sizeof($rateLimitMade)) {
            $rateLimits = [];
            $currentTime = time();

            for ($i = 0; $i < sizeof($rateLimitReset); $i++) {
                $rateLimit = new RateLimit();
                $numberOfMinutes = ($rateLimitReset[$i] - $currentTime) / 60;

                if ($numberOfMinutes <= 15) {
                    $rateLimit->IntervalMinutes = 15;
                } elseif ($numberOfMinutes <= 30) {
                    $rateLimit->IntervalMinutes = 30;
                } elseif ($numberOfMinutes <= 60) {
                    $rateLimit->IntervalMinutes = 60;
                } elseif ($numberOfMinutes <= 60 * 24) {
                    $rateLimit->IntervalMinutes = 60 * 24;
                }

                $rateLimit->CallsMade = $rateLimitMade[$i];
                $rateLimit->CallsRemaining = $rateLimitRemaining[$i];
                $rateLimit->ResetTimeTimestamp = $rateLimitReset[$i];

                $rateLimits[] = $rateLimit;
            }

            if (sizeof($rateLimits) > 0) {
                $this->_root->RateLimits = $rateLimits;
            }
        } else {
            $logClass::Debug("Could not set rate limits. Headers length should be the same");
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
        $this->_requestHttpHeaders = [];
        // content type
        array_push($this->_requestHttpHeaders, self::$_JSON_HEADER);
        // Add User-Agent Header

        array_push($this->_requestHttpHeaders, 'User-Agent: Mangopay-SDK/' . self::VERSION . ' (PHP/' . phpversion() . ')');

        if ($this->_root->Config->UKHeaderFlag) {
            array_push($this->_requestHttpHeaders, 'x-tenant-id: uk');
        }

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
        if ($responseCode >= 200 && $responseCode <= 299) {
            return;
        }

        if (!is_object($response) || !isset($response->Message)) {
            throw new ResponseException($this->_requestUrl, $responseCode);
        }

        $error = new Error();

        $map = [
            'Message',
            'Id',
            'Type',
            'Date',
            'Errors',
        ];

        foreach ($map as $val) {
            $error->{$val} = property_exists($response, $val) ? $response->{$val} : null;
        }

        if (property_exists($response, 'errors')) {
            $error->Errors = $response->errors;
        }

        if (is_array($error->Errors)) {
            foreach ($error->Errors as $key => $val) {
                $error->Message .= sprintf(' %s error: %s', $key, $val);
            }
        }

        throw new ResponseException($this->_requestUrl, $responseCode, $error);
    }
}
