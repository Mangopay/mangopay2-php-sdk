<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for cards
 */
class ApiCards extends Libraries\ApiBase
{
    /**
     * Get card
     * @param int $cardId Card identifier
     * @return \MangoPay\Card object returned from API
     */
    public function Get($cardId)
    {
        return $this->GetObject('card_get', $cardId, '\MangoPay\Card');
    }
    /**
     * Gets a list of cards having the same fingerprint.
     * The fingerprint is a hash uniquely generated per 16-digit card number.
     *
     * @param string $fingerprint The fingerprint hash
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array List of Cards corresponding to provided fingerprint
     */
    public function GetByFingerprint($fingerprint, $pagination = null)
    {
        return $this->GetList('cards_get_by_fingerprint', $pagination, '\MangoPay\Card', $fingerprint);
    }
    
    /**
     * Update card
     * @param \MangoPay\Card $card Card object to save
     * @return \MangoPay\Card Card object returned from API
     */
    public function Update($card)
    {
        return $this->SaveObject('card_save', $card, '\MangoPay\Card');
    }

}