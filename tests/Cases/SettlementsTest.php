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

    private function createNewSettlement()
    {
        if (self::$Settlement != null) {
            return self::$Settlement;
        }
        $file = file_get_contents(__DIR__ . '/../settlement_sample.csv');
        return $this->_api->Settlements->Upload($file);
    }
}
