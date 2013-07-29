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
    public $OAuth;
    
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
     * oAuth object with data to authentication with strong type
     * @var oAuth 
     */
    private static $_oAuth;
    
    /**
     * Constructor
     * @param OAuth $oauth OAuth object with data to authentication
     */
    function __construct($oauth = null) {
        
        $this->OAuth = new ApiOAuth();
        $oauth = $this->GetAuthenticationData($oauth);
        parent::__construct($oauth);
        
        $this->Clients = new ApiClients();
        $this->Users = new ApiUsers($oauth);
        $this->Wallets = new ApiWallets($oauth);
        $this->Transfers = new ApiTransfers($oauth);
        $this->PayIns = new ApiPayIns($oauth);
        $this->PayOuts = new ApiPayOuts($oauth);
    }

    /**
     * Get authentication data
     * @param MangoPay\oAuth $oauth
     * @return MangoPay\oAuth oAuth object or null if not strong authentication
     */
    private function GetAuthenticationData($oauth) {

        if (!is_null($oauth)) {
            return $oauth;  
        } elseif (MangoPay_AuthenticationType == AuthenticationType::Strong) {
            
            if (is_null(self::$_oAuth) || self::$_oAuth->IsExpire()) {
                self::$_oAuth = $this->OAuth->Token();
            }
            
            return self::$_oAuth;
        }
        
        return null;
    }
}