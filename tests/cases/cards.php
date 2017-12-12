<?php
namespace MangoPay\Tests;
require_once 'base.php';

/**
 * Tests methods for card registrations
 */
class Cards extends Base {

    function test_CardsByFingerprint_Get() {
        $john = $this->getNewJohn();
        $payIn = $this->getNewPayInCardDirect($john->Id);
        $card = $this->_api->Cards->Get($payIn->PaymentDetails->CardId);

        $cardsByFingerprint = $this->_api->Cards->GetByFingerprint($card->Fingerprint);

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
}