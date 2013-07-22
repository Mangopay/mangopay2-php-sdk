<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests bank accounts related methods for users
 */
class UsersBankAccounts extends Base {

    function testUsersCreateBankAccount() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $this->assertTrue($account->Id > 0);
        $this->assertIdentical($account->UserId, $john->Id);
    }

    function testUsersGetBankAccount() {
        $john = $this->getJohn();
        $account = $this->getJohnsAccount();
        $accountFetched = $this->_api->Users->GetBankAccount($john->Id, $account->Id);
        $this->assertIdenticalInputProps($account, $accountFetched);
    }
}
