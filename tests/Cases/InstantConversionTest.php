<?php

namespace MangoPay\Tests\Cases;

use MangoPay\InstantConversion;
use MangoPay\Money;
use MangoPay\TransactionType;

class InstantConversionTest extends Base
{
    public function test_getConversionRate()
    {
        $response = $this->_api->InstantConversion->GetConversionRate('EUR', 'GBP');

        $this->assertNotNull($response);
        $this->assertNotNull($response->ClientRate);
        $this->assertNotNull($response->MarketRate);
    }

    public function test_createInstantConversion()
    {
        $response = $this->createInstantConversion();

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertSame('SUCCEEDED', $response->Status);
        $this->assertSame(TransactionType::Conversion, $response->Type);
    }

    public function test_getInstantConversion()
    {
        $instantConversion = $this->createInstantConversion();
        $returnedInstantConversion = $this->_api->InstantConversion->GetInstantConversion($instantConversion->Id);

        $this->assertNotNull($returnedInstantConversion);
        $this->assertNotNull($returnedInstantConversion->DebitedFunds->Amount);
        $this->assertNotNull($returnedInstantConversion->CreditedFunds->Amount);
        $this->assertSame('SUCCEEDED', $returnedInstantConversion->Status);
        $this->assertSame(TransactionType::Conversion, $returnedInstantConversion->Type);
    }

    private function createInstantConversion() {
        $john = $this->getJohn();
        $creditedWallet = new \MangoPay\Wallet();
        $creditedWallet->Owners = [$john->Id];
        $creditedWallet->Currency = 'GBP';
        $creditedWallet->Description = 'WALLET IN EUR WITH MONEY';

        $creditedWallet = $this->_api->Wallets->Create($creditedWallet);

        $debitedWallet = $this->getJohnsWalletWithMoney();

        $instantConversion = new InstantConversion();
        $instantConversion->AuthorId = $debitedWallet->Owners[0];
        $instantConversion->CreditedWalletId = $creditedWallet->Id;
        $instantConversion->DebitedWalletId = $debitedWallet->Id;

        $creditedFunds = new Money();
        $creditedFunds->Currency = 'GBP';
        $instantConversion->CreditedFunds = $creditedFunds;

        $debitedFunds = new Money();
        $debitedFunds->Currency = 'EUR';
        $debitedFunds->Amount = 79;
        $instantConversion->DebitedFunds = $debitedFunds;

        $instantConversion->Tag = "create instant conversion";

        return $this->_api->InstantConversion->CreateInstantConversion($instantConversion);
    }
}