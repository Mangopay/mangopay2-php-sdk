<?php
namespace MangoPay\Libraries;

/**
 * Base class for Http Client
 */
abstract class HttpBase
{
    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    protected $_root;

    /**
     * Constructor
     * @param \MangoPay\MangoPayApi $root Root/parent instance that holds the OAuthToken and Configuration instance
     */
    public function __construct($root)
    {
        $this->_root = $root;
        $this->logger = $root->getLogger();
    }


    /**
     * @param RestTool $restTool
     *
     * @return HttpResponse
     */
    abstract public function Request(RestTool $restTool);
}
