<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests for holding authentication token in instance
 */
class Tokens extends Base {

    function test_forceToken() {
        $authHlp = new \MangoPay\Libraries\AuthenticationHelper($this->_api);
        
        $oldToken = $this->_api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        $newToken = $this->_api->AuthenticationManager->CreateToken();
        
        $this->assertNotEqual($oldToken->access_token, $newToken->access_token);
    }
    
    function test_storeToken() {
        $authHlp = new \MangoPay\Libraries\AuthenticationHelper($this->_api);
        $token = new \MangoPay\Libraries\OAuthToken();
        $token->access_token = 'access test';
        $token->token_type = 'type test';
        $token->expires_in = 500;
        $token->autentication_key = $authHlp->GetAutenticationKey();
        $this->_api->OAuthTokenManager->StoreToken($token);
                
        $storedToken = $this->_api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        
        $this->assertEqual('access test', $storedToken->access_token);
        $this->assertEqual('type test', $storedToken->token_type);
        
        $token->expires_in = 0;
        $this->_api->OAuthTokenManager->StoreToken($token);
    }
    
    function test_storeToken_differentAutenticationKey() {
        $authHlp = new \MangoPay\Libraries\AuthenticationHelper($this->_api);
        $token = new \MangoPay\Libraries\OAuthToken();
        $token->access_token = 'access test';
        $token->token_type = 'type test';
        $token->expires_in = 500;
        $token->autentication_key = 'old_value';
        $this->_api->OAuthTokenManager->StoreToken($token);
                
        $storedToken = $this->_api->OAuthTokenManager->GetToken('new_value');
        
        $this->assertNotEqual('access test', $storedToken->access_token);
        $this->assertNotEqual('type test', $storedToken->token_type);
        $this->assertEqual($authHlp->GetAutenticationKey(), $storedToken->autentication_key);
        
        $token->expires_in = 0;
        $this->_api->OAuthTokenManager->StoreToken($token);
    }
    
    function test_stadnardUseToken() {
        $authHlp = new \MangoPay\Libraries\AuthenticationHelper($this->_api);
        $token = $this->_api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        
        $this->_api->Users->GetAll();
        $tokenAfterCall = $this->_api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        
        $this->assertEqual($token->access_token, $tokenAfterCall->access_token);
        $this->assertEqual($token->token_type, $tokenAfterCall->token_type);
    }
    
    function test_isTokenLeaking() {
        $authHlp = new \MangoPay\Libraries\AuthenticationHelper($this->_api);
        $api = $this->buildNewMangoPayApi();
        
        $token1 = $this->_api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        $token2 = $api->OAuthTokenManager->GetToken($authHlp->GetAutenticationKey());
        
        $this->assertEqual($token1->access_token, $token2->access_token);
        $this->assertEqual($token1->token_type, $token2->token_type);
    }   
}
