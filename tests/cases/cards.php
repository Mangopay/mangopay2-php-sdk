<?php
namespace MangoPay\Tests;
use MangoPay\SortDirection;
use MangoPay\Sorting;

require_once 'base.php';

/**
 * Tests methods for card registrations
 */
class Cards extends Base {

    function test_CardsByFingerprint_Get() {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $sorting = new Sorting();
        $sorting->AddField("CreationDate", SortDirection::DESC);

        $cardsByFingerprint = $this->_api->Cards->GetByFingerprint($card->Fingerprint, $sorting);

        foreach($cardsByFingerprint as $cardByFingerprint) {
            $this->assertIdentical($cardByFingerprint->Fingerprint, $card->Fingerprint);
        }
    }

    function test_Card_GetPreAuthorizations() {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $preauthorizations = $this->_api->Cards->GetPreAuthorizations($card->Id);

        $this->assertNotNull($preauthorizations);
        $this->assertIsA($preauthorizations, 'array');
    }

    function test_Card_GetTransactions() {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->Cards->GetTransactions($card->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertIsA($transactions, 'array');
    }
}