<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsOTHER;

/**
 * Tests basic methods for Banking Aliases
 */
class SettlementsTest extends Base
{
    public static $Settlement;
    public function test_Settlements_Upload()
    {
        $created = $this->createNewSettlement();
        self::assertNotNull($created);
        self::assertEquals("UPLOADED", $created->Status);
    }

    public function test_Settlements_Get()
    {
        $created = $this->createNewSettlement();
        sleep(10);
        $fetched = $this->_api->Settlements->Get($created->SettlementId);
        self::assertNotNull($fetched);
        self::assertEquals("PARTIALLY_SETTLED", $fetched->Status);
    }

    public function test_Settlements_Update()
    {
        $created = $this->createNewSettlement();
        self::assertEquals("UPLOADED", $created->Status);
        $file = file_get_contents(__DIR__ . '/../settlement_sample.csv');
        $updated = $this->_api->Settlements->Update($created->SettlementId, $file);
        self::assertEquals("UPLOADED", $updated->Status);
        sleep(10);
        $fetched = $this->_api->Settlements->Get($updated->SettlementId);
        self::assertEquals("PARTIALLY_SETTLED", $fetched->Status);
    }

    private function createNewSettlement()
    {
        if (self::$Settlement != null) {
            return self::$Settlement;
        }
        $file = file_get_contents(__DIR__ . '/../settlement_sample.csv');
        return $this->_api->Settlements->Upload($file);
    }
}
