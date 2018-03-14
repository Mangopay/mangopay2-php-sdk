<?php

namespace MangoPay;

/**
 * Class to manage MangoPay API calls for the user entity.
 */
class ApiUsers extends Libraries\ApiBase
{
    /**
     * Create a new user
     * @param UserLegal|UserNatural $user
     * @return UserLegal|UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Create($user, $idempotencyKey = null)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural') {
            $methodKey = 'users_createnaturals';
        } elseif ($className == 'MangoPay\UserLegal') {
            $methodKey = 'users_createlegals';
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->CreateObject($methodKey, $user, null, null, null, $idempotencyKey);
        return $this->GetUserResponse($response);
    }

    /**
     * Get all users
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return array Array with users
     */
    public function GetAll(& $pagination = null, $sorting = null)
    {
        $usersList = $this->GetList('users_all', $pagination, null, null, null, $sorting);

        $users = array();
        if (is_array($usersList)) {
            foreach ($usersList as $user) {
                array_push($users, $this->GetUserResponse($user));
            }
        }
        return $users;
    }

    /**
     * Get natural or legal user by ID
     * @param int|GUID $userId User identifier
     * @return UserLegal | UserNatural User object returned from API
     */
    public function Get($userId)
    {
        $response = $this->GetObject('users_get', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get natural user by ID
     * @param int|GUID $userId User identifier
     * @return UserLegal|UserNatural User object returned from API
     */
    public function GetNatural($userId)
    {
        $response = $this->GetObject('users_getnaturals', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get legal user by ID
     * @param int|GUID $userId User identifier
     * @return UserLegal|UserNatural User object returned from API
     */
    public function GetLegal($userId)
    {
        $response = $this->GetObject('users_getlegals', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Save user
     * @param UserLegal|UserNatural $user
     * @return UserLegal|UserNatural User object returned from API
     * @throws Libraries\Exception If occur Wrong entity class for user
     */
    public function Update($user)
    {
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural') {
            $methodKey = 'users_savenaturals';
            if (!is_null($user->Address)
                && is_a($user->Address, "MangoPay\Address")
                && $user->Address->CanBeNull()) {
                $user->Address = null;
            }
        } elseif ($className == 'MangoPay\UserLegal') {
            $methodKey = 'users_savelegals';
            if (!is_null($user->HeadquartersAddress)
                && is_a($user->HeadquartersAddress, "MangoPay\Address")
                && $user->HeadquartersAddress->CanBeNull()) {
                $user->HeadquartersAddress = null;
            }
            if (!is_null($user->LegalRepresentativeAddress)
                && is_a($user->LegalRepresentativeAddress, "MangoPay\Address")
                && $user->LegalRepresentativeAddress->CanBeNull()) {
                $user->LegalRepresentativeAddress = null;
            }
        } else {
            throw new Libraries\Exception('Wrong entity class for user');
        }

        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Create bank account for user
     * @param int $userId User Id
     * @param \MangoPay\BankAccount $bankAccount Entity of bank account object
     * @return \MangoPay\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount, $idempotencyKey = null)
    {
        $type = $this->GetBankAccountType($bankAccount);
        return $this->CreateObject('users_createbankaccounts_' . $type, $bankAccount, '\MangoPay\BankAccount', $userId, null, $idempotencyKey);
    }

    /**
     * Get all bank accounts for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return array Array with bank account entities
     */
    public function GetBankAccounts($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allbankaccount', $pagination, 'MangoPay\BankAccount', $userId, null, $sorting);
    }

    /**
     * Get bank account for user
     * @param int $userId User Id
     * @param int $bankAccountId Bank account Id
     *
     * @return \MangoPay\BankAccount Entity of bank account object
     */
    public function GetBankAccount($userId, $bankAccountId)
    {
        return $this->GetObject('users_getbankaccount', $userId, 'MangoPay\BankAccount', $bankAccountId);
    }

    /**
     * Save a bank account
     * @param int $userId
     * @param \MangoPay\BankAccount $bankAccount
     * @return \MangoPay\BankAccount Entity of bank account object
     */
    public function UpdateBankAccount($userId, $bankAccount)
    {
        return $this->SaveObject('bankaccounts_save', $bankAccount, '\MangoPay\BankAccount', $userId);
    }

    /**
     * Get all wallets for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Wallet[] Array with objects returned from API
     */
    public function GetWallets($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allwallets', $pagination, 'MangoPay\Wallet', $userId, null, $sorting);
    }

    /**
     * Get all transactions for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Transaction[] Transactions for user returned from API
     */
    public function GetTransactions($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_alltransactions', $pagination, '\MangoPay\Transaction', $userId, $filter, $sorting);
    }

    /**
     * Get all cards for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return \MangoPay\Card[] Cards for user returned from API
     */
    public function GetCards($userId, & $pagination = null, $sorting = null)
    {
        return $this->GetList('users_allcards', $pagination, '\MangoPay\Card', $userId, null, $sorting);
    }

    /**
     * Create new KYC document
     * @param int $userId User Id
     * @param \MangoPay\KycDocument $kycDocument
     * @param string $idempotencyKey Key for response replication
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function CreateKycDocument($userId, $kycDocument, $idempotencyKey = null)
    {
        return $this->CreateObject('kyc_documents_create', $kycDocument, '\MangoPay\KycDocument', $userId, null, $idempotencyKey);
    }

    /**
     * Get all KYC documents for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @param \MangoPay\FilterKycDocuments $filter Object to filter data
     *
     * @return array Array with KYC documents entities
     */
    public function GetKycDocuments($userId, & $pagination = null, $sorting = null, $filter = null)
    {
        return $this->GetList('users_allkycdocuments', $pagination, 'MangoPay\KycDocument', $userId, $filter, $sorting);
    }

    /**
     * Get KYC document
     * @param int $userId User Id
     * @param string $kycDocumentId Document identifier
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function GetKycDocument($userId, $kycDocumentId)
    {
        return $this->GetObject('kyc_documents_get', $userId, '\MangoPay\KycDocument', $kycDocumentId);
    }

    /**
     * Get all mandates for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return array Array with mandate entities
     */
    public function GetMandates($userId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_allmandates', $pagination, 'MangoPay\Mandate', $userId, $filter, $sorting);
    }

    /**
     * Get mandates for user and bank account
     * @param int $userId User Id
     * @param int $bankAccountId Bank account Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     *
     * @return array Array with mandate entities
     */
    public function GetMandatesForBankAccount($userId, $bankAccountId, & $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('users_allbankaccount_mandates', $pagination, 'MangoPay\Mandate', $userId, $filter, $sorting, $bankAccountId);
    }

    /**
     * Save KYC document
     * @param int $userId User Id
     * @param \MangoPay\KycDocument $kycDocument Document to save
     * @return \MangoPay\KycDocument Document returned from API
     */
    public function UpdateKycDocument($userId, $kycDocument)
    {
        return $this->SaveObject('kyc_documents_save', $kycDocument, '\MangoPay\KycDocument', $userId);
    }

    /**
     * Create page for Kyc document
     * @param int $userId User Id
     * @param int $kycDocumentId KYC Document Id
     * @param \MangoPay\KycPage $kycPage KYC Page
     * @throws \MangoPay\Libraries\Exception
     */
    public function CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('kyc_page_create', $kycPage, null, $userId, $kycDocumentId, $idempotencyKey);
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }

    /**
     * Create page for Kyc document from file
     * @param int $userId User Id
     * @param int $kycDocumentId KYC Document Id
     * @param string $filePath File path
     * @throws \MangoPay\Libraries\Exception
     */
    public function CreateKycPageFromFile($userId, $kycDocumentId, $filePath, $idempotencyKey = null)
    {

        if (empty($filePath)) {
            throw new \MangoPay\Libraries\Exception('Path of file cannot be empty');
        }

        if (!file_exists($filePath)) {
            throw new \MangoPay\Libraries\Exception('File not exist');
        }

        $kycPage = new \MangoPay\KycPage();
        $kycPage->File = base64_encode(file_get_contents($filePath));

        if (empty($kycPage->File)) {
            throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
        }

        $this->CreateKycPage($userId, $kycDocumentId, $kycPage, $idempotencyKey);
    }

    /**
     * Get user EMoney
     * @param int $userId User Id
     * @return \MangoPay\EMoney EMoney obhect returned from API
     */
    public function GetEMoney($userId)
    {
        return $this->GetObject('users_getemoney', $userId, '\MangoPay\EMoney');
    }

    /**
     * Create a UBO declaration.
     * @param string $userId ID of the legal user owning the declaration
     * @param \MangoPay\UboDeclaration $declaration UBO declaration data
     * @return \MangoPay\UboDeclaration Newly-created UBO declaration object
     */
    public function CreateUboDeclaration($userId, $declaration)
    {
        return $this->CreateObject('ubo_declaration_create', $declaration, '\MangoPay\UboDeclaration', $userId);
    }

    /**
     * Gets a list with PreAuthorizations belonging to a specific user
     * @param string $userId ID of the user whose PreAuthorizations to retrieve
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterPreAuthorizations $filter Filtering object
     * @param \MangoPay\Sorting $sorting Sorting object
     * @return array The user's PreAuthorizations
     */

    public function GetPreAuthorizations($userId, $pagination = null, $filter = null, $sorting = null)
    {
        return $this->GetList('preauthorizations_get_for_user', $pagination, '\MangoPay\CardPreAuthorization', $userId, $filter, $sorting);
    }

    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal|UserNatural User object returned from API
     * @throws \MangoPay\Libraries\Exception If occur unexpected response from API
     */
    private function GetUserResponse($response)
    {
        if (isset($response->PersonType)) {
            switch ($response->PersonType) {
                case PersonType::Natural:
                    return $this->CastResponseToEntity($response, '\MangoPay\UserNatural');
                case PersonType::Legal:
                    return $this->CastResponseToEntity($response, '\MangoPay\UserLegal');
                default:
                    throw new Libraries\Exception('Unexpected response. Wrong PersonType value');
            }
        } else {
            throw new Libraries\Exception('Unexpected response. Missing PersonType property');
        }
    }

    private function GetBankAccountType($bankAccount)
    {
        if (!isset($bankAccount->Details) || !is_object($bankAccount->Details)) {
            throw new Libraries\Exception('Details is not defined or it is not object type');
        }

        $className = str_replace('MangoPay\\BankAccountDetails', '', get_class($bankAccount->Details));
        return strtolower($className);
    }
}
