<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for Apple Pay pay-ins
 */
class ApiPayInsApple extends Libraries\ApiBase
{

    /**
     * Create new Apple Pay pay-in object
     * @param $applePayIn \MangoPay\PayInApple object
     * @param null $idempotencyKey
     * @return \MangoPay\PayInApple Object returned from API
     */
    public function Create($applePayIn, $idempotencyKey = null)
    {
        return $this->CreateObject("payins_applepay", $applePayIn, '\MangoPay\PayInApple', null, null, $idempotencyKey);
    }

}