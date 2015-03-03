<?php
namespace MangoPay\Tools;

use MangoPay\Enums;

/**
 * Class to management MangoPay API for users
 */
class ApiUsers extends ApiBase {

    /**
     * Create a new user
     * @param UserLegal/UserNatural $user
     * @return UserLegal/UserNatural User object returned from API
     */
    public function Create($user) {

        $className = get_class($user);
        if ($className == 'MangoPay\Entities\UserNatural')
            $methodKey = 'users_createnaturals';
        elseif ($className == 'MangoPay\Entities\UserLegal')
            $methodKey = 'users_createlegals';
        else
            throw new Exception('Wrong entity class for user');

        $response = $this->CreateObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Get all users
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return array Array with users
     */
    public function GetAll(& $pagination = null, $sorting = null) {
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
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     */
    public function Get($userId) {

        $response = $this->GetObject('users_get', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get natural user by ID
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     */
    public function GetNatural($userId) {

        $response = $this->GetObject('users_getnaturals', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Get legal user by ID
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     */
    public function GetLegal($userId) {

        $response = $this->GetObject('users_getlegals', $userId);
        return $this->GetUserResponse($response);
    }

    /**
     * Save user
     * @param UserLegal/UserNatural $user
     * @return UserLegal/UserNatural User object returned from API
     */
    public function Update($user) {

        $className = get_class($user);
        if ($className == 'MangoPay\Entities\UserNatural')
            $methodKey = 'users_savenaturals';
        elseif ($className == 'MangoPay\Entities\UserLegal')
            $methodKey = 'users_savelegals';
        else
            throw new Exception('Wrong entity class for user');

        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }

    /**
     * Create bank account for user
     * @param int $userId User Id
     * @param \MangoPay\Entities\BankAccount $bankAccount Entity of bank account object
     * @return \MangoPay\Entities\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount) {
        $type = $this->GetBankAccountType($bankAccount);
        return $this->CreateObject('users_createbankaccounts_' . $type, $bankAccount, '\MangoPay\Entities\BankAccount', $userId);
    }

    /**
     * Get all bank accounts for user
     * @param int $userId User Id
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return array Array with bank account entities
     */
    public function GetBankAccounts($userId, & $pagination = null, $sorting = null) {
        return $this->GetList('users_allbankaccount', $pagination, 'MangoPay\Entities\BankAccount', $userId, null, $sorting);
    }

    /**
     * Get bank account for user
     * @param int $userId User Id
     * @param int $bankAccountId Bank account Id
     * @return \MangoPay\Entities\BankAccount Entity of bank account object
     */
    public function GetBankAccount($userId, $bankAccountId) {
        return $this->GetObject('users_getbankaccount', $userId, 'MangoPay\Entities\BankAccount', $bankAccountId);
    }

    /**
     * Get all wallets for user
     * @param int $userId User Id
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return \MangoPay\Entities\Wallet[] Array with objects returned from API
     */
    public function GetWallets($userId, & $pagination = null, $sorting = null) {
        return $this->GetList('users_allwallets', $pagination, 'MangoPay\Entities\Wallet', $userId, null, $sorting);
    }

    /**
     * Get all transactions for user
     * @param int $userId User Id
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\FilterTransactions $filter Object to filter data
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return \MangoPay\Entities\Transaction[] Transactions for user returned from API
     */
    public function GetTransactions($userId, & $pagination = null, $filter = null, $sorting = null) {
        return $this->GetList('users_alltransactions', $pagination, '\MangoPay\Entities\Transaction', $userId, $filter, $sorting);
    }

    /**
     * Get all cards for user
     * @param int $userId User Id
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return \MangoPay\Entities\Card[] Cards for user returned from API
     */
    public function GetCards($userId, & $pagination = null, $sorting = null) {
        return $this->GetList('users_allcards', $pagination, '\MangoPay\Entities\Card', $userId, null, $sorting);
    }

    /**
     * Create new KYC document
     * @param int $userId User Id
     * @param \MangoPay\Entities\KycDocument $kycDocument
     * @return \MangoPay\Entities\KycDocument Document returned from API
     */
    public function CreateKycDocument($userId, $kycDocument) {
        return $this->CreateObject('kyc_documents_create', $kycDocument, '\MangoPay\Entities\KycDocument', $userId);
    }

    /**
     * Get all KYC documents for user
     * @param int $userId User Id
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param \MangoPay\Tools\Sorting $sorting Object to sorting data
     * @return array Array with KYC documents entities
     */
    public function GetKycDocuments($userId, & $pagination = null, $sorting = null) {
        return $this->GetList('users_allkycdocuments', $pagination, 'MangoPay\Entities\KycDocument', $userId, null, $sorting);
    }

    /**
     * Get KYC document
     * @param int $userId User Id
     * @param string $kycDocumentId Document identifier
     * @return \MangoPay\Entities\KycDocument Document returned from API
     */
    public function GetKycDocument($userId, $kycDocumentId) {
        return $this->GetObject('kyc_documents_get', $userId, '\MangoPay\Entities\KycDocument', $kycDocumentId);
    }

    /**
     * Save KYC document
     * @param int $userId User Id
     * @param \MangoPay\Entities\KycDocument $kycDocument Document to save
     * @return \MangoPay\Entities\KycDocument Document returned from API
     */
    public function UpdateKycDocument($userId, $kycDocument) {
        return $this->SaveObject('kyc_documents_save', $kycDocument, '\MangoPay\Entities\KycDocument', $userId);
    }

    /**
     * Create page for Kyc document
     * @param int $userId User Id
     * @param \MangoPay\Entities\KycPage $page Kyc
     */
    public function CreateKycPage($userId, $kycDocumentId, $kycPage) {

        try{
            $this->CreateObject('kyc_page_create', $kycPage, null, $userId, $kycDocumentId);
        } catch (\MangoPay\Types\Exceptions\ResponseException $exc) {
            if ($exc->getCode() != 204)
                throw $exc;
        }
    }

    /**
     * Create page for Kyc document from file
     * @param int $userId User Id
     * @param \MangoPay\Entities\KycPage $page Kyc
     */
    public function CreateKycPageFromFile($userId, $kycDocumentId, $file) {

        $filePath = $file;
        if (is_array($file)) {
            $filePath = $file['tmp_name'];
        }

        if (empty($filePath))
            throw new \MangoPay\Types\Exceptions\Exception('Path of file cannot be empty');

        if (!file_exists($filePath))
            throw new \MangoPay\Types\Exceptions\Exception('File not exist');

        $kycPage = new \MangoPay\Entities\KycPage();
        $kycPage->File = base64_encode(file_get_contents($filePath));

        if (empty($kycPage->File))
            throw new \MangoPay\Types\Exceptions\Exception('Content of the file cannot be empty');

        $this->CreateKycPage($userId, $kycDocumentId, $kycPage);
    }

    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Types\Exceptions\Exception If occur unexpected response from API
     */
    private function GetUserResponse($response) {

        if (isset($response->PersonType)) {

            switch ($response->PersonType) {
                case Enums\PersonType::Natural:
                    return $this->CastResponseToEntity($response, '\MangoPay\Entities\UserNatural');
                case Enums\PersonType::Legal:
                    return $this->CastResponseToEntity($response, '\MangoPay\Entities\UserLegal');
                default:
                    throw new Exception('Unexpected response. Wrong PersonType value');
            }
        } else {
            throw new Exception('Unexpected response. Missing PersonType property');
        }
    }

    private function GetBankAccountType($bankAccount) {

        if (!isset($bankAccount->Details) || !is_object($bankAccount->Details))
            throw new Exception ('Details is not defined or it is not object type');

        $className = str_replace('MangoPay\\Types\\BankAccountDetails', '', get_class($bankAccount->Details));
        return strtolower($className);
    }
}
