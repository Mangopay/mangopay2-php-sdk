<?php
namespace MangoPay;

/**
 * Class to manage MangoPay API for bank accounts
 */
class ApiBankAccounts extends Libraries\ApiBase
{

    /**
     * Retrieves a list of Transactions pertaining to a certain Bank Account
     * @param string $bankAccountId Bank Account identifier
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     */
    public function GetTransactions($bankAccountId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('transactions_get_for_bank_account', $pagination, '\MangoPay\Transaction', $bankAccountId, $filter, $sorting);
    }
}
