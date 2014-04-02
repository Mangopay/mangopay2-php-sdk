<?php
namespace MangoPay;
require_once __DIR__ . '/common/common.inc';

/**
 * MangoPay API main entry point.
 * Provides managers to connect, send and read data from MangoPay API
 * as well as holds configuration/authorization data.
 */
class MangoPayApi {

    /////////////////////////////////////////////////
    // Config/authorization related props
    /////////////////////////////////////////////////

    /**
     * Authorization token methods
     * @var \MangoPay\AuthorizationTokenManager
     */
    public $OAuthTokenManager;

    /**
     * Configuration instance
     * @var \MangoPay\Configuration
     */
    public $Config;

    /////////////////////////////////////////////////
    // API managers props
    /////////////////////////////////////////////////

    /**
     * OAuth methods
     * @var ApiOAuth
     */
    public $AuthenticationManager;

    /**
     * Clients methods
     * @var Client
     */
    public $Clients;

    /**
     * Users methods
     * @var ApiUsers
     */
    public $Users;

    /**
     * Wallets methods
     * @var ApiWallets
     */
    public $Wallets;

    /**
     * Transfers methods
     * @var ApiTransfers
     */
    public $Transfers;

    /**
     * Pay-in methods
     * @var ApiPayIns
     */
    public $PayIns;

    /**
     * Pay-out methods
     * @var ApiPayOuts
     */
    public $PayOuts;

    /**
     * Refund methods
     * @var ApiRefunds
     */
    public $Refunds;

    /**
     * Card registration methods
     * @var ApiCardRegistrations
     */
    public $CardRegistrations;

    /**
     * Pre-authorization methods
     * @var ApiCardPreAuthorization
     */
    public $CardPreAuthorizations;

    /**
     * Card methods
     * @var ApiCards
     */
    public $Cards;

    /**
     * Events methods
     * @var ApiEvents
     */
    public $Events;

    /**
     * Hooks methods
     * @var ApiHooks
     */
    public $Hooks;

    /**
     * Constructor
     */
    function __construct($debug = false) {

        // default config setup
        $this->Config = new Configuration();
        $this->OAuthTokenManager = new AuthorizationTokenManager($this);

        // API managers
        $this->AuthenticationManager = new ApiOAuth($this, $debug);
        $this->Clients = new ApiClients($this, $debug);
        $this->Users = new ApiUsers($this, $debug);
        $this->Wallets = new ApiWallets($this, $debug);
        $this->Transfers = new ApiTransfers($this, $debug);
        $this->PayIns = new ApiPayIns($this, $debug);
        $this->PayOuts = new ApiPayOuts($this, $debug);
        $this->Refunds = new ApiRefunds($this, $debug);
        $this->CardRegistrations = new ApiCardRegistrations($this, $debug);
        $this->Cards = new ApiCards($this, $debug);
        $this->Events = new ApiEvents($this, $debug);
        $this->Hooks = new ApiHooks($this, $debug);
        $this->CardPreAuthorizations = new ApiCardPreAuthorizations($this, $debug);
    }
}
