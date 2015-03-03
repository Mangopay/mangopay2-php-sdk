<?php
namespace MangoPay\Tools;

/**
 * Storage strategy interface.
 */
interface IStorageStrategy {

    /**
     * Gets the current authorization token.
     * @return \MangoPay\Types\OAuthToken Currently stored token instance or null.
     */
    function Get();

    /**
     * Stores authorization token passed as an argument.
     * @param \MangoPay\Types\OAuthToken $token Token instance to be stored.
     */
    function Store($token);
}
