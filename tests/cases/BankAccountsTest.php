<?php

namespace MangoPay\Tests\Cases;


use MangoPay\Tests\Cases\Base;

/**
 * Tests basic methods for Banking Aliases
 */
class BankAccountsTest extends Base
{

    function test_BankAccount_GetTransactions()
    {
        $bankAccount = $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->BankAccounts->GetTransactions($bankAccount->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertInternalType('array', $transactions);
    }
}
