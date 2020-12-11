<?php

namespace MangoPay\Tests\Cases;


use MangoPay\BankAccount;
use MangoPay\BankAccountDetailsOTHER;

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

    function test_create_bank_account_other(){
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
}
