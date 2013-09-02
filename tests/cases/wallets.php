<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests basic methods for wallets
 */
class Wallets extends Base {
    
    function test_Wallets_Create() {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();
        
        $this->assertTrue($wallet->Id > 0);
        $this->assertTrue(in_array($john->Id, $wallet->Owners));
    }
    
    function test_Wallets_Get() {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();
        
        $getWallet = $this->_api->Wallets->Get($wallet->Id);
        
        $this->assertIdentical($wallet->Id, $getWallet->Id);
        $this->assertTrue(in_array($john->Id, $getWallet->Owners));
    }
    
    function test_Wallets_Save() {
        $wallet = $this->getJohnsWallet();
        $wallet->Description = 'New description to test';
        
        $saveWallet = $this->_api->Wallets->Update($wallet);
        
        $this->assertIdentical($wallet->Id, $saveWallet->Id);
        $this->assertIdentical('New description to test', $saveWallet->Description);
    }
    
    function test_Wallets_Transactions() {
        $john = $this->getJohn();
        $wallet = $this->getJohnsWallet();
        $payIn = $this->getJohnsPayInCardWeb();

        $pagination = new \MangoPay\Pagination(1, 1);
        $filter = new \MangoPay\FilterTransactions();
        $filter->Type = 'PAYIN';
        $transactions = $this->_api->Wallets->GetTransactions($wallet->Id, $pagination, $filter);

        $this->assertEqual(count($transactions), 1);
        $this->assertIsA($transactions[0], '\MangoPay\Transaction');
        $this->assertEqual($transactions[0]->AuthorId, $john->Id);
        $this->assertIdenticalInputProps($transactions[0], $payIn);
    }
}