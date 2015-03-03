<?php
namespace MangoPay\Tools;

/**
 * Class to management MangoPay API for cards
 */
class ApiCards extends ApiBase {

    /**
     * Get card
     * @param int $cardId Card identifier
     * @return \MangoPay\Entities\Card object returned from API
     */
    public function Get($cardId) {
        return $this->GetObject('card_get', $cardId, '\MangoPay\Entities\Card');
    }

    /**
     * Update card
     * @param \MangoPay\Entities\Card $card Card object to save
     * @return \MangoPay\Entities\Card Card object returned from API
     */
    public function Update($card) {
        return $this->SaveObject('card_save', $card, '\MangoPay\Entities\Card');
    }

    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Create new temporary payment card
     * @param \MangoPay\Entities\TemporaryPaymentCard $paymentCard Payment card object to create
     * @return \MangoPay\Entities\TemporaryPaymentCard Card registration object returned from API
     */
    public function CreateTemporaryPaymentCard($paymentCard) {
        return $this->CreateObject('temp_paymentcards_create', $paymentCard, '\MangoPay\Entities\TemporaryPaymentCard');
    }

    /**
     * WARNING!!
     * It's temporary entity and it will be removed in the future.
     * Please, contact with support before using these features or if you have any questions.
     *
     * Get temporary payment card
     * @param string $paymentCardId Card identifier
     * @return \MangoPay\Entities\TemporaryPaymentCard object returned from API
     */
    public function GetTemporaryPaymentCard($paymentCardId) {
        return $this->GetObject('temp_paymentcards_get', $paymentCardId, '\MangoPay\Entities\TemporaryPaymentCard');
    }
}
