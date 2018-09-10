<?php

namespace MangoPay\Tests\Cases;

use MangoPay\SortDirection;
use MangoPay\Sorting;


/**
 * Tests methods for card registrations
 */
class CardsTest extends Base
{

    function test_CardsByFingerprint_Get()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $sorting = new Sorting();
        $sorting->AddField("CreationDate", SortDirection::DESC);

        $cardsByFingerprint = $this->_api->Cards->GetByFingerprint($card->Fingerprint, $sorting);

        foreach ($cardsByFingerprint as $cardByFingerprint) {
            $this->assertSame($card->Fingerprint, $cardByFingerprint->Fingerprint);
        }
    }

    function test_Card_GetPreAuthorizations()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $preauthorizations = $this->_api->Cards->GetPreAuthorizations($card->Id);

        $this->assertNotNull($preauthorizations);
        $this->assertInternalType('array', $preauthorizations);
    }

    function test_Card_GetTransactions()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->Cards->GetTransactions($card->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertInternalType('array', $transactions);
    }
}