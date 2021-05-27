<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests methods for pay-outs
 */
class PayOutsTest extends Base
{
    public function test_PayOut_Create()
    {
        $payOut = $this->getJohnsPayOutForCardDirect();

        $this->assertTrue($payOut->Id > 0);
        $this->assertSame(\MangoPay\PayOutPaymentType::BankWire, $payOut->PaymentType);
        $this->assertInstanceOf('\MangoPay\PayOutPaymentDetailsBankWire', $payOut->MeanOfPaymentDetails);
    }

    public function test_PayOut_Get()
    {
        $payOut = $this->getJohnsPayOutForCardDirect();

        $payOutGet = $this->_api->PayOuts->Get($payOut->Id);

        $this->assertSame($payOut->Id, $payOutGet->Id);
        $this->assertSame($payOut->PaymentType, $payOutGet->PaymentType);
        #this passes on local, there is a mix in the tests ran by travis
        #$this->assertSame(\MangoPay\PayOutStatus::Created, $payOutGet->Status);
        $this->assertIdenticalInputProps($payOut, $payOutGet);
        $this->assertNull($payOutGet->ExecutionDate);
    }

    public function test_PayOut_Bankwire_get()
    {
        $payOut = $this->getJohnsPayOutForCardDirect();

        $payOutGet = $this->_api->PayOuts->GetBankwire($payOut->Id);

        $this->assertSame($payOut->Id, $payOutGet->Id);
        $this->assertSame($payOut->PaymentType, $payOutGet->PaymentType);
        #this passes on local, there is a mix in the tests ran by travis
        #$this->assertSame(\MangoPay\PayOutStatus::Created, $payOutGet->Status);
        $this->assertNull($payOutGet->ExecutionDate);
        $this->assertSame($payOutGet->MeanOfPaymentDetails->ModeRequested, "STANDARD");
    }

    // Cannot test anything else here: have no pay-ins with sufficient status?
    public function test_PayOuts_Create_BankWire_FailsCauseNotEnoughMoney()
    {
        $payOut = $this->getJohnsPayOutBankWire();

        $this->assertSame(\MangoPay\PayOutStatus::Failed, $payOut->Status);
    }

    public function test_PayOut_GetRefunds()
    {
        $payOut = $this->getJohnsPayOutForCardDirect();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterRefunds();

        $refunds = $this->_api->PayOuts->GetRefunds($payOut->Id, $pagination, $filter);

        $this->assertNotNull($refunds);
        $this->assertInternalType('array', $refunds);
    }
}
