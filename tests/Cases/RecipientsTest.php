<?php

namespace Cases;

use MangoPay\CurrencyIso;
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
        self::assertNotNull($recipient->PendingUserAction);
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
        $john = $this->getJohnSca(UserCategory::Owner, false);
        $this->getNewRecipient();
        $userRecipients = $this->_api->Recipients->GetUserRecipients($john->Id);
        self::assertTrue(sizeof($userRecipients) > 0);
    }

    private function assertRecipient($recipient)
    {
        self::assertNotNull($recipient);
        self::assertNotNull($recipient->Status);
        self::assertNotNull($recipient->DisplayName);
        self::assertNotNull($recipient->PayoutMethodType);
        self::assertNotNull($recipient->RecipientType);
        self::assertNotNull($recipient->IndividualRecipient);
        self::assertNotNull($recipient->LocalBankTransfer);
        self::assertNotNull($recipient->LocalBankTransfer->GBP);
        self::assertNotNull($recipient->LocalBankTransfer->GBP->SortCode);
        self::assertNotNull($recipient->LocalBankTransfer->GBP->AccountNumber);
    }

    private function getNewRecipient()
    {
        if (self::$recipient == null) {
            $john = $this->getJohnSca(UserCategory::Owner, false);

            $localBankTransfer = [];
            $gbpDetails = [];
            $gbpDetails["SortCode"] = "010039";
            $gbpDetails["AccountNumber"] = "11696419";
            $localBankTransfer["GBP"] = $gbpDetails;

            $individualRecipient = new IndividualRecipient();
            $individualRecipient->FirstName = "Payout";
            $individualRecipient->LastName = "Team";
            $individualRecipient->Address = $this->getNewAddress();

            $recipient = new Recipient();
            $recipient->DisplayName = "My GB account";
            $recipient->PayoutMethodType = "LocalBankTransfer";
            $recipient->RecipientType = "Individual";
            $recipient->Currency = CurrencyIso::GBP;
            $recipient->IndividualRecipient = $individualRecipient;
            $recipient->LocalBankTransfer = $localBankTransfer;

            self::$recipient = $this->_api->Recipients->Create($recipient, $john->Id);
        }
        return self::$recipient;
    }
}
