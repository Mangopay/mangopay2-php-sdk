<?php
namespace MangoPay\DemoWorkflow;
/**
 * Same as storage strategy implementation for tests
 */
class MockStorageStrategy implements \MangoPay\Tools\IStorageStrategy {

    private static $_oAuthToken = null;

    /**
     * Gets the current authorization token.
     * @return \MangoPay\Entities\OAuthToken Currently stored token instance or null.
     */
    public function Get() {
        return self::$_oAuthToken;
    }
    /**
     * Stores authorization token passed as an argument.
     * @param \MangoPay\Entities\OAuthToken $token Token instance to be stored.
     */
    public function Store($token) {
        self::$_oAuthToken = $token;
    }
}
