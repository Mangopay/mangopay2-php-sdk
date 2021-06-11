<?php

namespace MangoPay\Tests\Cases;

use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsOTHER;

/**
 * Tests basic methods for Banking Aliases
 */
class BankAccountsTest extends Base
{
    public function test_BankAccount_GetTransactions()
    {
        $bankAccount = $this->getJohnsAccount();
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->BankAccounts->GetTransactions($bankAccount->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertTrue(is_array($transactions), 'Expected an array');
    }

    public function test_create_bank_account_other()
    {
        $john = $this->getJohn();
        $account = new BankAccount();
        $account->OwnerName = "ANTHONY TEST";
        $account->OwnerAddress = $john->Address;
        $account->Details = new BankAccountDetailsOTHER();
        $account->Details->Type = "OTHER";
        $account->Details->Country = "FR";
        $account->Details->AccountNumber = "ABC123";
        $account->Details->BIC = "CELLLULL";

        $bankAccount = $this->_api->Users->CreateBankAccount($john->Id, $account);

        $this->assertNotNull($bankAccount);
    }

    public function test_update_bank_account()
    {
        $john = $this->getJohn();
        //creates an account to John
        $account = $this->getJohnsAccount();

        $accounts = $this->_api->Users->GetBankAccounts($john->Id);
        $bankAccountToDeactivate = clone $accounts[0];
        //should be active
        $this->assertTrue($bankAccountToDeactivate->Active);
        $bankAccountToDeactivate->Active = false;
        $updated = $this->_api->Users->UpdateBankAccount($john->Id, $bankAccountToDeactivate);

        //shouldn't be active
        $this->assertNotNull($updated);
        $this->assertNotTrue($updated->Active);
    }

    public function test_issue_420()
    {
        $john = $this->getJohn();
        $userId = $john->Id;
        //creates an account to John, as it does not have any
        $account = $this->getJohnsAccount();
        $this->_api->Users->GetBankAccounts($userId);
        $bankAccount = $this->_api->Users->GetBankAccounts($userId)[0];
        $bankAccount = $this->_api->Users->GetBankAccount($userId, $bankAccount->Id);
        $bankAccountToDeactivate = clone $bankAccount;
        $bankAccountToDeactivate->Active = false;
        /*$bk = $this->api->Users->UpdateBankAccount($userId, $bankAccount);*/
        /*dd($this->api->Users->GetBankAccount($userId,$bankAccount->Id));*/
        $bk = $this->_api->Users->UpdateBankAccount($userId, $bankAccountToDeactivate);

        //shouldn't be active
        $this->assertNotNull($bk);
        $this->assertNotTrue($bk->Active);
    }
}
