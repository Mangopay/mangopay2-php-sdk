<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for Banking Aliases
 */
class ApiBankingAliases extends Libraries\ApiBase
{
    /**
     * Get a banking alias
     * @param int $bankingAliasId Banking alias identifier
     * @return \MangoPay\BankingAlias object returned from API
     */
    public function Get($bankingAliasId)
    {
        $response = $this->GetObject('banking_aliases_get', $bankingAliasId);
        return $this->GetBankingAliasResponse($response);
    }

    /**
     * Create a banking alias
     * @param \MangoPay\BankingAlias $bankingAlias Banking alias
     * @return \MangoPay\BankingAlias object returned from API
     */
    public function Create($bankingAlias)
    {
        $className = get_class($bankingAlias);
        if ($className == 'MangoPay\BankingAliasIBAN') {
            $methodKey = 'banking_aliases_iban_create';
        } else {
            throw new Libraries\Exception('Wrong entity class for BankingAlias');
        }

        return $this->CreateObject('banking_aliases_create', $bankingAlias, '\MangoPay\BankingAlias');
    }

    /**
     * Update banking alias
     * @param \MangoPay\BankingAlias $bankingAlias Card object to save
     * @return \MangoPay\BankingAlias Card object returned from API
     */
    public function Update($bankingAlias)
    {
        return $this->SaveObject('banking_aliases_update', $bankingAlias, '\MangoPay\BankingAlias');
    }

    /**
     * Get all banking aliases
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return \MangoPay\BankingAlias[] List of banking aliases
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        return $this->GetList('banking_aliases_all', $pagination, '\MangoPay\BankingAlias', null, null, $sorting);
    }

    /**
     * Get correct banking alias object
     * @param object $response Response from API
     * @return object BankingAlias object returned from API
     * @throws \MangoPay\Libraries\Exception If occur unexpected response from API
     */
    private function GetBankingAliasResponse($response)
    {
        if (isset($response->Type)) {
            switch ($response->Type) {
                case BankingAliasType::IBAN:
                    return $this->CastResponseToEntity($response, '\MangoPay\BankingAliasIBAN');
                default:
                    throw new Libraries\Exception('Unexpected response. Wrong BankingAlias Type value');
            }
        } else {
            throw new Libraries\Exception('Unexpected response. Missing BankingAlias Type property');
        }
    }

}
