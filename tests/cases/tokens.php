<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests for holding authentication token in instance
 */
class Tokens extends Base {

    function test_forceToken() {
        // create token
        $token = $this->_api->AuthenticationManager->CreateToken();
        // overwrite token in API
        $this->_api->OAuthToken = $token;
        $this->_api->Users->GetAll();
        $this->assertIdentical($token->access_token, $this->_api->OAuthToken->access_token);
    }
    
    function test_stadnardUseToken() {
        $this->_api->Users->GetAll();
        $token = $this->_api->OAuthToken;
        $this->_api->Users->GetAll();
        $this->assertIdentical($token->access_token, $this->_api->OAuthToken->access_token);
    }
    
    function test_isTokenLeaking() {
        // create separate api
        $api = $this->buildNewMangoPayApi();
        $this->_api->Users->GetAll();
        $api->Users->GetAll();
        $this->assertTrue($api->OAuthToken->access_token != $this->_api->OAuthToken->access_token);
    }    
}
