<?php

namespace MangoPay\Tests\Mocks;

use MangoPay\Libraries\IStorageStrategy;
use MangoPay\Libraries\OAuthToken;

/**
 * Storage strategy implementation for tests
 */
class MockStorageStrategy implements IStorageStrategy
{
    /** @var null|OAuthToken  */
    private static $_oAuthToken = null;

    /**
     * Gets the current authorization token.
     * @return null|OAuthToken Currently stored token instance or null.
     */
    public function Get()
    {
        return self::$_oAuthToken;
    }

    /**
     * Stores authorization token passed as an argument.
     * @param OAuthToken $token Token instance to be stored.
     */
    public function Store($token)
    {
        self::$_oAuthToken = $token;
    }
}
