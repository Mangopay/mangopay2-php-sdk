<?php

namespace MangoPay\Tests\Cases;

use MangoPay\InstantConversion;
use MangoPay\Money;
use MangoPay\Quote;
use MangoPay\TransactionType;

class ConversionsTest extends Base
{
    public function test_getConversionRate()
    {
        $response = $this->_api->Conversions->GetConversionRate('EUR', 'GBP');

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
        $returnedInstantConversion = $this->_api->Conversions->GetInstantConversion($instantConversion->Id);

        $this->assertNotNull($returnedInstantConversion);
        $this->assertNotNull($returnedInstantConversion->DebitedFunds->Amount);
        $this->assertNotNull($returnedInstantConversion->CreditedFunds->Amount);
        $this->assertSame('SUCCEEDED', $returnedInstantConversion->Status);
        $this->assertSame(TransactionType::Conversion, $returnedInstantConversion->Type);
    }

    public function test_createQuote(){
        $response = $this->createQuote();

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertNotNull($response->ConversionRateResponse->ClientRate);
        $this->assertSame('ACTIVE', $response->Status);
    }

    public function test_getQuote(){
        $quote = $this->createQuote();
        $response = $this->_api->Conversions->GetQuote($quote->Id);

        $this->assertNotNull($response);
        $this->assertNotNull($response->DebitedFunds->Amount);
        $this->assertNotNull($response->CreditedFunds->Amount);
        $this->assertNotNull($response->ConversionRateResponse->ClientRate);
        $this->assertSame('ACTIVE', $response->Status);
    }

    private function createInstantConversion()
    {
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

        return $this->_api->Conversions->CreateInstantConversion($instantConversion);
    }

    private function createQuote()
    {

        $quote = new Quote();
        $creditedFunds = new Money();
        $creditedFunds->Currency = 'USD';
        $quote->CreditedFunds = $creditedFunds;

        $debitedFunds = new Money();
        $debitedFunds->Currency = 'GBP';
        $debitedFunds->Amount = 1000;
        $quote->DebitedFunds = $debitedFunds;

        $quote->Duration = 90;
        $quote->Tag = "Created using the Mangopay PHP SDK";

        return $this->_api->Conversions->CreateQuote($quote);

    }
}
