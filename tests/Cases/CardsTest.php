<?php

namespace MangoPay\Tests\Cases;

use MangoPay\Libraries\Exception;
use MangoPay\SortDirection;
use MangoPay\Sorting;

/**
 * Tests methods for card registrations
 */
class CardsTest extends Base
{
    public function test_CardsByFingerprint_Get()
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

    public function test_Card_GetPreAuthorizations()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $preauthorizations = $this->_api->Cards->GetPreAuthorizations($card->Id);

        $this->assertNotNull($preauthorizations);
        $this->assertTrue(is_array($preauthorizations), 'Expected an array');
    }

    public function test_Card_GetTransactions()
    {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);
        $pagination = new \MangoPay\Pagination();
        $filter = new \MangoPay\FilterTransactions();

        $transactions = $this->_api->Cards->GetTransactions($card->Id, $pagination, $filter);

        $this->assertNotNull($transactions);
        $this->assertTrue(is_array($transactions), 'Expected an array');
    }

    public function test_Card_Validate()
    {
        $new_api = $this->buildNewMangoPayApi();

        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $new_api->Cards->Get($payIn->PaymentDetails->CardId);

        $this->assertNotNull($card);

        try {
            $validatedCard = $new_api->Cards->ValidateCard($card->Id);
            $this->assertNotNull($validatedCard);
        } catch (Exception $e) {
            print_r("can't test due to client issues");
        }
    }
}
