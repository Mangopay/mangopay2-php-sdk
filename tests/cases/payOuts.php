<?php

namespace MangoPay\Tests;

require_once 'base.php';

/**
 * Tests methods for pay-outs
 */
class PayOuts extends Base {

    // Cannot test anything else here: have no pay-ins with sufficient status?
    function test_PayOuts_Create_BankWire_FailsCauseNotEnoughMoney() {
        try {
            $payIn = $this->getJohnsPayInCardWeb();
            $payOut = $this->getJohnsPayOutBankWire();

            $this->fail('Should throw ResponseException');
        } catch (\MangoPay\ResponseException $ex) {
            $this->assertIdentical($ex->getCode(), 400);
        } catch (\Exception $ex) {
            $this->fail('Should throw ResponseException');
        }
    }

}

