<?php

namespace Cases;

use Exception;
use MangoPay\CurrencyIso;
use MangoPay\FilterRecipients;
use MangoPay\IndividualRecipient;
use MangoPay\Recipient;
use MangoPay\Tests\Cases\Base;
use MangoPay\UserCategory;

/**
 * Tests basic methods for recipients
 */
class RecipientsTest extends Base
{
    public static $recipient;

    public function test_Recipient_Create()
    {
        $recipient = $this->getNewRecipient();
        $this->assertRecipient($recipient);
    }

    public function test_Recipient_Get()
    {
        $recipient = $this->getNewRecipient();
        $fetched = $this->_api->Recipients->Get($recipient->Id);
        $this->assertRecipient($fetched);
        self::assertEquals($recipient->Id, $fetched->Id);
    }

    public function test_Recipient_GetUserRecipients()
    {
        $john = $this->getJohnSca(UserCategory::Payer, false);
        $this->getNewRecipient();
        $userRecipients = $this->_api->Recipients->GetUserRecipients($john->Id);
        self::assertTrue(sizeof($userRecipients) > 0);
    }

    public function test_Recipient_GetUserRecipients_Payout()
    {
        $john = $this->getJohnSca(UserCategory::Payer, false);
        $this->getNewRecipient();
        $filter = new FilterRecipients();
        $filter->RecipientScope = "PAYOUT";
        $userRecipients = $this->_api->Recipients->GetUserRecipients($john->Id, null, null, $filter);
        self::assertTrue(sizeof($userRecipients) > 0);
    }

    public function test_Recipient_GetUserRecipients_PayIn()
    {
        $john = $this->getJohnSca(UserCategory::Payer, false);
        $this->getNewRecipient();
        $filter = new FilterRecipients();
        $filter->RecipientScope = "PAYIN";
        $userRecipients = $this->_api->Recipients->GetUserRecipients($john->Id, null, null, $filter);
        self::assertTrue(sizeof($userRecipients) == 0);
    }

    public function test_Recipient_GetPayoutMethods()
    {
        $payoutMethods = $this->_api->Recipients->GetPayoutMethods("DE", "EUR");
        self::assertNotNull($payoutMethods);
        self::assertTrue(sizeof($payoutMethods->AvailablePayoutMethods) > 0);
    }

    public function test_Recipient_GetSchema_LocalBankTransferIndividual()
    {
        $schema = $this->_api->Recipients->GetSchema(
            "LocalBankTransfer",
            "Individual",
            "GBP",
            "GB"
        );
        self::assertNotNull($schema);
        self::assertNotNull($schema->DisplayName);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->DisplayName);
        self::assertNotNull($schema->Currency);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->Currency);
        self::assertNotNull($schema->RecipientType);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->RecipientType);
        self::assertNotNull($schema->PayoutMethodType);
        self::assertNotNull($schema->RecipientScope);
        self::assertNotNull($schema->Tag);
        self::assertNotNull($schema->LocalBankTransfer);
        self::assertIsArray($schema->LocalBankTransfer, 'LocalBankTransfer should be an array');
        self::assertArrayHasKey('GBP', $schema->LocalBankTransfer);
        self::assertIsArray($schema->LocalBankTransfer['GBP'], 'LocalBankTransfer["GBP"] should be an array');
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->LocalBankTransfer['GBP']['AccountNumber']);
        self::assertNotNull($schema->IndividualRecipient);
        self::assertNull($schema->BusinessRecipient);
        self::assertNull($schema->InternationalBankTransfer);
        self::assertNotNull($schema->Country);
    }

    public function test_Recipient_GetSchema_InternationalBankTransferBusiness()
    {
        $schema = $this->_api->Recipients->GetSchema(
            "InternationalBankTransfer",
            "Business",
            "GBP",
            "GB"
        );
        self::assertNotNull($schema);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->DisplayName);
        self::assertNotNull($schema->Currency);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->Currency);
        self::assertNotNull($schema->RecipientType);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->RecipientType);
        self::assertNotNull($schema->PayoutMethodType);
        self::assertNotNull($schema->RecipientScope);
        self::assertNotNull($schema->Tag);
        self::assertNotNull($schema->BusinessRecipient);
        self::assertNotNull($schema->InternationalBankTransfer);
        self::assertIsArray($schema->InternationalBankTransfer, 'InternationalBankTransfer should be an array');
        self::assertArrayHasKey('AccountNumber', $schema->InternationalBankTransfer);
        self::assertInstanceOf('\MangoPay\RecipientPropertySchema', $schema->InternationalBankTransfer['AccountNumber']);
        self::assertNull($schema->LocalBankTransfer);
        self::assertNull($schema->IndividualRecipient);
        self::assertNotNull($schema->Country);
    }

    public function test_Recipient_Validate()
    {
        $john = $this->getJohnSca(UserCategory::Payer, false);
        $recipient = $this->getNewRecipient();

        // should pass
        $this->_api->Recipients->Validate($recipient, $john->Id);

        $recipient->Currency = null;
        try {
            // should fail
            $this->_api->Recipients->Validate($recipient, $john->Id);
        } catch (Exception $e) {
            $message = $e->getMessage();
            self::assertTrue(str_contains($message, "One or several required parameters are missing or incorrect"));
        }
    }

    public function test_Recipient_Deactivate()
    {
        $this->markTestSkipped("A recipient needs to be manually activated before running the test");
        $recipientId = "rec_01JS1CAB9YFYW72EXC68W4KT59";
        $deactivated = $this->_api->Recipients->Deactivate($recipientId);
        $afterDeactivation = $this->_api->Recipients->Get($deactivated->Id);
        self::assertEquals("DEACTIVATED", $deactivated->Status);
        self::assertEquals("DEACTIVATED", $afterDeactivation->Status);
    }

    /**
     * @param $recipient Recipient
     * @return void
     */
    private function assertRecipient($recipient)
    {
        self::assertNotNull($recipient);
        self::assertNotNull($recipient->Status);
        self::assertNotNull($recipient->DisplayName);
        self::assertNotNull($recipient->PayoutMethodType);
        self::assertNotNull($recipient->RecipientType);
        self::assertNotNull($recipient->RecipientScope);
        self::assertNotNull($recipient->UserId);
        self::assertNotNull($recipient->IndividualRecipient);
        self::assertNotNull($recipient->LocalBankTransfer);
        self::assertNotNull($recipient->LocalBankTransfer->EUR);
        self::assertNotNull($recipient->LocalBankTransfer->EUR->IBAN);
        self::assertNotNull($recipient->Country);
        self::assertNotNull($recipient->RecipientVerificationOfPayee);
    }

    private function getNewRecipient()
    {
        if (self::$recipient == null) {
            $john = $this->getJohnSca(UserCategory::Payer, false);

            $localBankTransfer = [];
            $details = [];
            $details["SortCode"] = "010039";
            $details["AccountNumber"] = "11696419";
            $details["IBAN"] = "DE75512108001245126199";
            $localBankTransfer["EUR"] = $details;

            $individualRecipient = new IndividualRecipient();
            $individualRecipient->FirstName = "John";
            $individualRecipient->LastName = "Doe";
            $individualRecipient->Address = $this->getNewAddress();

            $recipient = new Recipient();
            $recipient->DisplayName = "My DE account";
            $recipient->PayoutMethodType = "LocalBankTransfer";
            $recipient->RecipientType = "Individual";
            $recipient->Currency = CurrencyIso::EUR;
            $recipient->IndividualRecipient = $individualRecipient;
            $recipient->LocalBankTransfer = $localBankTransfer;
            $recipient->Country = "DE";

            self::$recipient = $this->_api->Recipients->Create($recipient, $john->Id);
        }
        return self::$recipient;
    }
}
