<?php
namespace MangoPay;
require_once __DIR__ . '/common/common.inc';

/**
 * Manager to connect, send and read data from MangoPay API
 */
class MangoPayApi extends ApiBase {
    
    /**
     * Clients methods
     * @var Client 
     */
    public $Clients;
    
    /**
     * OAuth methods
     * @var ApiAuth
     */
    public $OAuthManager;
    
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
     * Constructor
     */
    function __construct($oauth = null) {
	
		self::$Config = new Configuration();
		
		if (defined('MangoPay_ClientId')) {
			self::$Config->ClientId = MangoPay_ClientId;
		}
		if (defined('MangoPay_ClientPassword')) {
			self::$Config->ClientPassword = MangoPay_ClientPassword;
		}
		if (defined('MangoPay_BaseUrl')) {
			self::$Config->BaseUrl = MangoPay_BaseUrl;
		}
        
        $this->OAuthManager = new ApiOAuth();
        
        $this->Clients = new ApiClients();
        $this->Users = new ApiUsers();
        $this->Wallets = new ApiWallets();
        $this->Transfers = new ApiTransfers();
        $this->PayIns = new ApiPayIns();
        $this->PayOuts = new ApiPayOuts();
    }
}