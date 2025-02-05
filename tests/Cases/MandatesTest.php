<?php

namespace MangoPay\Tests\Cases;

use MangoPay\MandateStatus;

/**
 * Tests basic methods for mandates
 */
class MandatesTest extends Base
{
    public function test_Mandates_Create()
    {
        $john = $this->getJohn();

        $mandate = $this->getJohnsMandate();

        $this->assertNotNull($mandate->Id);
        $this->assertEquals($john->Id, $mandate->UserId);
        $this->assertSame(MandateStatus::Created, $mandate->Status);
    }

    public function test_Mandates_Get()
    {
        $john = $this->getJohn();
        $mandate = $this->getJohnsMandate();

        $getMandate = $this->_api->Mandates->Get($mandate->Id);

        $this->assertSame($mandate->Id, $getMandate->Id);
        $this->assertEquals($john->Id, $getMandate->UserId);
    }

    public function test_Mandates_Cancel()
    {
        $mandate = $this->getJohnsMandate();

        try {
            $this->_api->Mandates->Cancel($mandate->Id);

            $this->fail('Expected ResponseException when cancel a mandate with status CREATED');
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            $this->assertSame(400, $exc->getCode());
        }
    }

    public function test_Mandates_GetAll()
    {
        $this->getJohnsMandate();

        $pagination = new \MangoPay\Pagination();
        $mandates = $this->_api->Mandates->GetAll($pagination);

        $this->assertTrue(count($mandates) > 0);
    }

    public function test_Mandate_GetTransactions()
    {
        $mandate = $this->getJohnsMandate();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->Mandates->GetTransactions($mandate->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertTrue(is_array($transactions), 'Expected an array');
    }
}
