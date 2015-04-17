<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests for holding authentication token in instance
 */
class Tokens extends Base {

    function test_forceToken() {
        $oldToken = $this->_api->OAuthTokenManager->getToken();
        $newToken = $this->_api->AuthenticationManager->createToken();
        
        $this->assertNotEqual($oldToken->access_token, $newToken->access_token);
    }
    
    function test_storeToken() {
        $token = new \MangoPay\Libraries\OAuthToken();
        $token->access_token = 'access test';
        $token->token_type = 'type test';
        $token->expires_in = 500;
        $this->_api->OAuthTokenManager->storeToken($token);
        
        $storedToken = $this->_api->OAuthTokenManager->getToken();
        
        $this->assertEqual('access test', $storedToken->access_token);
        $this->assertEqual('type test', $storedToken->token_type);
        
        $token->expires_in = 0;
        $this->_api->OAuthTokenManager->storeToken($token);
    }
    
    function test_stadnardUseToken() {
        $token = $this->_api->OAuthTokenManager->getToken();
        
        $this->_api->Users->GetAll();
        $tokenAfterCall = $this->_api->OAuthTokenManager->getToken();
        
        $this->assertEqual($token->access_token, $tokenAfterCall->access_token);
        $this->assertEqual($token->token_type, $tokenAfterCall->token_type);
    }
    
    function test_isTokenLeaking() {
        $api = $this->buildNewMangoPayApi();
        
        $token1 = $this->_api->OAuthTokenManager->getToken();
        $token2 = $api->OAuthTokenManager->getToken();
        
        $this->assertEqual($token1->access_token, $token2->access_token);
        $this->assertEqual($token1->token_type, $token2->token_type);
    }    
}
