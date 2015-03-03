<?php
namespace MangoPay;

use MangoPay\Tools;
use MangoPay\Types;

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
     * @var \MangoPay\Tools\AuthorizationTokenManager
     */
    public $OAuthTokenManager;

    /**
     * Configuration instance
     * @var \MangoPay\Types\Configuration
     */
    public $Config;

    /////////////////////////////////////////////////
    // API managers props
    /////////////////////////////////////////////////

    /**
     * OAuth methods
     * @var \MangoPay\Tools\ApiOAuth
     */
    public $AuthenticationManager;

    /**
     * Clients methods
     * @var \MangoPay\Tools\ApiClients
     */
    public $Clients;

    /**
     * Users methods
     * @var \MangoPay\Tools\ApiUsers
     */
    public $Users;

    /**
     * Wallets methods
     * @var \MangoPay\Tools\ApiWallets
     */
    public $Wallets;

    /**
     * Transfers methods
     * @var \MangoPay\Tools\ApiTransfers
     */
    public $Transfers;

    /**
     * Pay-in methods
     * @var \MangoPay\Tools\ApiPayIns
     */
    public $PayIns;

    /**
     * Pay-out methods
     * @var \MangoPay\Tools\ApiPayOuts
     */
    public $PayOuts;

    /**
     * Refund methods
     * @var \MangoPay\Tools\ApiRefunds
     */
    public $Refunds;

    /**
     * Card registration methods
     * @var \MangoPay\Tools\ApiCardRegistrations
     */
    public $CardRegistrations;

    /**
     * Pre-authorization methods
     * @var \MangoPay\Tools\ApiCardPreAuthorization
     */
    public $CardPreAuthorizations;

    /**
     * Card methods
     * @var \MangoPay\Tools\ApiCards
     */
    public $Cards;

    /**
     * Events methods
     * @var \MangoPay\Tools\ApiEvents
     */
    public $Events;

    /**
     * Hooks methods
     * @var \MangoPay\Tools\ApiHooks
     */
    public $Hooks;

    /**
     * Kyc documents list
     * @var \MangoPay\Tools\ApiKycDocuments
     */
    public $KycDocuments;

    /**
     * Constructor
     */
    function __construct() {

        // default config setup
        $this->Config = new Types\Configuration();
        $this->OAuthTokenManager = new Tools\AuthorizationTokenManager($this);

        // API managers
        $this->AuthenticationManager = new Tools\ApiOAuth($this);
        $this->Clients = new Tools\ApiClients($this);
        $this->Users = new Tools\ApiUsers($this);
        $this->Wallets = new Tools\ApiWallets($this);
        $this->Transfers = new Tools\ApiTransfers($this);
        $this->PayIns = new Tools\ApiPayIns($this);
        $this->PayOuts = new Tools\ApiPayOuts($this);
        $this->Refunds = new Tools\ApiRefunds($this);
        $this->CardRegistrations = new Tools\ApiCardRegistrations($this);
        $this->Cards = new Tools\ApiCards($this);
        $this->Events = new Tools\ApiEvents($this);
        $this->Hooks = new Tools\ApiHooks($this);
        $this->CardPreAuthorizations = new Tools\ApiCardPreAuthorizations($this);
        $this->KycDocuments = new Tools\ApiKycDocuments($this);
    }
}
