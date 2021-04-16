<?php

namespace MangoPay\Tests\Cases;

/**
 * Tests basic methods for Banking Aliases
 */
class BankingAliasTest extends Base
{
    public function test_BankingAlias_Create()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $this->assertTrue($bankingAliasIBAN->Id > 0);
    }

    public function test_BankingAlias_Get()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();

        $getBankingAliasIBAN = $this->_api->BankingAliases->Get($bankingAliasIBAN->Id);

        $this->assertSame($bankingAliasIBAN->Id, $getBankingAliasIBAN->Id);
    }

    public function test_BankingAlias_Update()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $bankingAliasIBAN->Active = false;

        $saveBankingAliasIBAN = $this->_api->BankingAliases->Update($bankingAliasIBAN);

        $this->assertSame($bankingAliasIBAN->Id, $saveBankingAliasIBAN->Id);
        $this->assertSame(false, $saveBankingAliasIBAN->Active);
    }

    public function test_BankingAlias_All()
    {
        $bankingAliasIBAN = $this->getJohnsBankingAliasIBAN();
        $pagination = new \MangoPay\Pagination(1, 1);

        $list = $this->_api->BankingAliases->GetAll($bankingAliasIBAN->WalletId, $pagination);

        $this->assertInstanceOf('MangoPay\BankingAliasIBAN', $list[0]);
        $this->assertSame($bankingAliasIBAN->Id, $list[0]->Id);
        $this->assertSame(1, $pagination->Page);
        $this->assertSame(1, $pagination->ItemsPerPage);
    }
}
