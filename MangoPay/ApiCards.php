<?php

namespace MangoPay;

/**
 * Class to management MangoPay API for cards
 */
class ApiCards extends Libraries\ApiBase
{
    /**
     * Get card
     * @param string $cardId Card identifier
     * @return \MangoPay\Card object returned from API
     */
    public function Get($cardId)
    {
        return $this->GetObject('card_get', '\MangoPay\Card', $cardId);
    }

    /**
     * Gets a list of cards having the same fingerprint.
     * The fingerprint is a hash uniquely generated per 16-digit card number.
     *
     * @param string $fingerprint The fingerprint hash
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\Card[] List of Cards corresponding to provided fingerprint
     */
    public function GetByFingerprint($fingerprint, & $pagination = null, $sorting = null)
    {
        return $this->GetList('cards_get_by_fingerprint', $pagination, '\MangoPay\Card', $fingerprint, null, $sorting);
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

    /**
     * Gets a Card's PreAuthorizations
     * @param int $cardId ID of the Card for which to retrieve PreAuthorizations
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterPreAuthorizations filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\CardPreAuthorization[] List of the Card's PreAuthorizations
     */
    public function GetPreAuthorizations($cardId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList("preauthorizations_get_for_card", $pagination, '\MangoPay\CardPreAuthorization', $cardId, $filter, $sorting);
    }

    /**
     * Retrieves a list of Transactions pertaining to a certain Card
     * @param string $cardId Card identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return \MangoPay\Transaction[]
     */
    public function GetTransactions($cardId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('transactions_get_for_card', $pagination, '\MangoPay\Transaction', $cardId, $filter, $sorting);
    }

    /**
     * Validate a card
     * @param $cardId
     * @return \MangoPay\Card
     * @throws Libraries\Exception
     */
    public function ValidateCard($cardId)
    {
        return $this->GetObject('card_validate', '\MangoPay\Card', $cardId);
    }
}
