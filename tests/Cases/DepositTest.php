<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for disputes
 */
class DepositTest extends Base
{

    /**
     * @throws \Exception
     */
    public function test_Deposits_Create()
    {
        $cardRegistration = $this->getCardRegistrationForDeposit();
        $user = $this->getJohn();

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));

        $this->assertNotNull($deposit);
    }
}
