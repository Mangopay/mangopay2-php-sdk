<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for Banking Aliases
 */
class BankingAlias extends Base {

    function test_BankingAlias_Create() {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $this->assertTrue($bankingAliasIBAN->Id > 0);
    }

    function test_BankingAlias_Get() {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $getBankingAliasIBAN = $this->_api->BankingAliases->Get($bankingAliasIBAN->Id);

        $this->assertIdentical($getBankingAliasIBAN->Id, $bankingAliasIBAN->Id);
    }

    function test_BankingAlias_Update() {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $bankingAliasIBAN->Active = false;

        $saveBankingAliasIBAN = $this->_api->BankingAliases->Update($bankingAliasIBAN);

        $this->assertIdentical($saveBankingAliasIBAN->Id, $bankingAliasIBAN->Id);
        $this->assertIdentical($saveBankingAliasIBAN->Active, false);
    }

    function test_BankingAlias_All() {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $pagination = new \MangoPay\Pagination(1, 1);

        $list = $this->_api->BankingAliases->GetAll($bankingAliasIBAN->WalletId, $pagination);

        $this->assertIsA($list[0], '\MangoPay\BankingAliasIBAN');
        $this->assertIdentical($bankingAliasIBAN->Id, $list[0]->Id);
        $this->assertIdentical($pagination->Page, 1);
        $this->assertIdentical($pagination->ItemsPerPage, 1);
    }
}
