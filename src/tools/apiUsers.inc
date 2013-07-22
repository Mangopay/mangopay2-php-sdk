<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiUsers extends ApiBase {
    
    /**
     * Createa new user
     * @param UserLegal/UserNatural $user
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function Create($user) {
        
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural')
            $methodKey = 'users_createnaturals';
        elseif ($className == 'MangoPay\UserLegal')
            $methodKey = 'users_createlegals';
        else
            throw new Exception('Wrong entity class for user');
        
        $response = $this->CreateObject($methodKey, $user);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Create bank account for user
     * @param int $userId User Id
     * @param MangoPay\BankAccount $bankAccount Entity of bank account object
     * @return MangoPay\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount) {
        return $this->CreateObject('users_createbankaccounts', $bankAccount, 'MangoPay\BankAccount', $userId);
    }
    
    /**
     * Get all users
     * @return array Array with users
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function All(& $pagination = null) {
        $usersList = $this->GetList('users_all', $pagination);
        
        $users = array();
        foreach ($usersList as $user) {
            array_push($users, $this->GetUserResponse($user));
        }
        
        return $users;
    }
    
    /**
     * Get natural or legal user by ID
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function Get($userId) {
        
        $response = $this->GetObject('users_get', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Get natural user by ID
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function GetNatural($userId) {
        
        $response = $this->GetObject('users_getnaturals', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Get legal user by ID
     * @param Int/GUID $userId User identifier
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function GetLegal($userId) {
        
        $response = $this->GetObject('users_getlegals', $userId);
        return $this->GetUserResponse($response);
    }
    
    /**
     * Save user
     * @param UserLegal/UserNatural $user
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function Save($user) {
        
        $className = get_class($user);
        if ($className == 'MangoPay\UserNatural')
            $methodKey = 'users_savenaturals';
        elseif ($className == 'MangoPay\UserLegal')
            $methodKey = 'users_savelegals';
        else
            throw new Exception('Wrong entity class for user');
        
        $response = $this->SaveObject($methodKey, $user);
        return $this->GetUserResponse($response);        
    }    
    
    /**
     * Get bank account for user
     * @param int $userId User Id
     * @param int $bankAccountId Bank account Id
     * @return \MangoPay\BankAccount Entity of bank account object
     */
    public function GetBankAccount($userId, $bankAccountId) {
        return $this->GetObject('users_getbankaccount', $userId, 'MangoPay\BankAccount', $bankAccountId);
    }
    
    /**
     * Get all bank accounts for user
     * @param int $userId User Id
     * @param MangoPay\Pagination $pagination Pagination object
     * @return array Array with bank account entities
     */    
    public function BankAccounts($userId, & $pagination = null) {
        return $this->GetList('users_allbankaccount', $pagination, 'MangoPay\BankAccount', $userId);
    }
    
    /**
     * Get all wallets for user
     * @param Int/GUID $userId User identifier
     * @return array Array with mangoPay\Wallet obects returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function Wallets($userId, & $pagination = null) {
        return $this->GetList('users_allwallets', $pagination, 'MangoPay\Wallet', $userId);
    }
    
    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    private function GetUserResponse($response) {
        
        if (isset($response->PersonType)) {
            
            switch ($response->PersonType) {
                case PersonType::Natural:
                    return $this->CastResponseToEntity($response, 'MangoPay\UserNatural');
                case PersonType::Legal:
                    return $this->CastResponseToEntity($response, 'MangoPay\UserLegal');
                default:
                    throw new Exception('Unexpected response. Wrong PersonType value');
            }            
        } else {
            throw new Exception('Unexpected response. Missing PersonType property');
        }
    }
}