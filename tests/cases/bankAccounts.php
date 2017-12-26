<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for Banking Aliases
 */
class BankAccounts extends Base {

    function test_BankAccount_GetTransactions() {
        $bankAccount = $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->BankAccounts->GetTransactions($bankAccount->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertIsA($transactions, 'array');
    }
}
