<?php

namespace MangoPay\Tests\Cases;

use MangoPay\VirtualAccount;
use MangoPay\Wallet;
use function PHPUnit\Framework\assertNotTrue;

/**
 * Tests basic methods for Virtual Accounts
 */
class VirtualAccountsTest extends Base
{
    /**
     * @var \MangoPay\VirtualAccount
     */
    public static $johnsVirtualAccount;
    public function test_VirtualAccount_Create()
    {
        $wallet = $this->getJohnsWallet();
        $virtualAccount = new VirtualAccount();
        $virtualAccount->Country = "FR";
        $virtualAccount->VirtualAccountPurpose = "Collection";
        $virtualAccount->Tag = "create virtual account tag";

        self::$johnsVirtualAccount = $this->_api->VirtualAccounts->Create($virtualAccount, $wallet->Id);

        $this->assertNotNull(self::$johnsVirtualAccount);
        $this->assertEquals(self::$johnsVirtualAccount->WalletId, $wallet->Id);
    }

    public function test_VirtualAccount_Get()
    {
        $wallet = $this->getJohnsWallet();

        $virtualAccounts = $this->_api->VirtualAccounts->GetAll($wallet->Id);

        $this->assertNotNull($virtualAccounts);
        $this->assertTrue(is_array($virtualAccounts), 'Expected an array');
    }

    public function test_VirtualAccount_GetAll()
    {
        $wallet = $this->getJohnsWallet();

        $virtualAccounts = $this->_api->VirtualAccounts->GetAll($wallet->Id);

        $this->assertNotNull($virtualAccounts);
        $this->assertTrue(is_array($virtualAccounts), 'Expected an array');
    }

    public function test_VirtualAccount_Get_Availabilities()
    {
        $virtualAccountAvailabilities = $this->_api->VirtualAccounts->GetAvailabilities();

        $this->assertNotNull($virtualAccountAvailabilities);
        $this->assertTrue(is_array($virtualAccountAvailabilities->Collection), 'Expected an array');
        $this->assertTrue(is_array($virtualAccountAvailabilities->UserOwned), 'Expected an array');
    }

    public function test_VirtualAccount_Deactivate()
    {
        $wallet = $this->getJohnsWallet();
        self::$johnsVirtualAccount->Active = false;
        $deactivatedVirtualAccount = $this->_api->VirtualAccounts->Deactivate(self::$johnsVirtualAccount, $wallet->Id, self::$johnsVirtualAccount->Id);

        $this->assertNotTrue($deactivatedVirtualAccount->Active);
    }
}