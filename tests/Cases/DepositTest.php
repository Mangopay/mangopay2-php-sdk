<?php

namespace MangoPay\Tests\Cases;

use MangoPay\CancelDeposit;

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

    /**
     * @throws \Exception
     */
    public function test_Deposits_Get()
    {
        $cardRegistration = $this->getCardRegistrationForDeposit();
        $user = $this->getJohn();

        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
        $fetchedDeposit = $this->_api->Deposits->Get($deposit->Id);

        $this->assertEquals($deposit->Id, $fetchedDeposit->Id);
    }

//    /**
//     * @throws \Exception
//     */
//    public function test_Deposits_Cancel()
//    {
//        $cardRegistration = $this->getCardRegistrationForDeposit();
//        $user = $this->getJohn();
//
//        $deposit = $this->_api->Deposits->Create($this->getNewDeposit($cardRegistration->CardId, $user->Id));
//
//        $dto = new CancelDeposit();
//        $dto->PaymentStatus = "CANCELED";
//
//        $this->_api->Deposits->Cancel($deposit->Id, $dto);
//
//        $fetchedDeposit = $this->_api->Deposits->Get($deposit->Id);
//
//        $this->assertEquals("CANCELED", $fetchedDeposit->PaymentStatus);
//    }
}
