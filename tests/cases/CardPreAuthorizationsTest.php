<?php

namespace MangoPay\Tests\Cases;

use MangoPay\AVSResult;

/**
 * Tests methods for pay-ins
 */
class CardPreAuthorizationsTest extends Base
{

    function test_CardPreAuthorization_Create()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();

        $this->assertTrue($cardPreAuthorization->Id > 0);
        $this->assertSame(\MangoPay\CardPreAuthorizationStatus::Succeeded, $cardPreAuthorization->Status);
        $this->assertSame(\MangoPay\CardPreAuthorizationPaymentStatus::Waiting, $cardPreAuthorization->PaymentStatus);
        $this->assertSame('DIRECT', $cardPreAuthorization->ExecutionType);
        $this->assertNull($cardPreAuthorization->PayInId);
        $this->assertSame(AVSResult::FULL_MATCH, $cardPreAuthorization->SecurityInfo->AVSResult);
    }

    function test_CardPreAuthorization_Get()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();

        $getCardPreAuthorization = $this->_api->CardPreAuthorizations->Get($cardPreAuthorization->Id);

        $this->assertSame($getCardPreAuthorization->Id, $cardPreAuthorization->Id);
        $this->assertSame('000000', $getCardPreAuthorization->ResultCode);
    }

    function test_CardPreAuthorization_Update()
    {
        $cardPreAuthorization = $this->getJohnsCardPreAuthorization();
        $cardPreAuthorization->PaymentStatus = \MangoPay\CardPreAuthorizationPaymentStatus::Canceled;

        $resultCardPreAuthorization = $this->_api->CardPreAuthorizations->Update($cardPreAuthorization);

        $this->assertSame(\MangoPay\CardPreAuthorizationStatus::Succeeded, $resultCardPreAuthorization->Status);
        $this->assertSame(\MangoPay\CardPreAuthorizationPaymentStatus::Canceled, $resultCardPreAuthorization->PaymentStatus);
    }
}
