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
     * Get all users
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with users
     */
    public function All(& $pagination = null) {
        $usersList = $this->GetList('users_all', $pagination);
        
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
     * Create KYC request for user
     * @param int $userId User Id
     * @param \MangoPay\KYCRequest $kycRequest Entity of KYC request object
     * @return \MangoPay\KYCRequest Create KYC request object
     */
    public function CreateKycRequests($userId, $kycRequest) {
        $response = $this->CreateObject('users_createkycrequests', $kycRequest, null, $userId);
        return $this->GetKycRequestResponse($response);
    }

    /**
     * Get all KYC requests for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with KYC request entities
     */    
    public function KycRequests($userId, & $pagination = null) {
        $list = $this->GetList('users_allkycrequests', $pagination, null, $userId);
        
        $kycRequests = array();
        if (is_array($list)) {
            foreach ($list as $kycRequest) {
                array_push($kycRequests, $this->GetKycRequestResponse($kycRequest));
            }
        }
        
        return $kycRequests;
    }
    
    /**
     * Create KYC request for user
     * @param int $userId User Id
     * @param int $kycRequestId KYC request Id
     * @return \MangoPay\KYCRequest Create KYC request object
     */
    public function GetKycRequests($userId, $kycRequestId) {
        $response = $this->GetObject('users_getkycrequests', $userId, null, $kycRequestId);
        return $this->GetKycRequestResponse($response);
    }

    /**
     * Get proof of identity file
     * @param int $userId User Id
     * @return \MangoPay\File File object with document
     */
    public function ProofOfIdentity($userId) {
        return $this->GetObject('users_getproofofidentity', $userId, '\MangoPay\File');
    }
    
    /**
     * Get proof of address file
     * @param int $userId User Id
     * @return \MangoPay\File File object with document
     */
    public function ProofOfAddress($userId) {
        return $this->GetObject('users_getproofofaddress', $userId, '\MangoPay\File');
    }
    
    /**
     * Get proof of registration file
     * @param int $userId User Id
     * @return \MangoPay\File File object with document
     */
    public function ProofOfRegistration ($userId) {
        return $this->GetObject('users_getproofofregistration', $userId, '\MangoPay\File');
    }
    
    /**
     * Get shareholder declaration file
     * @param int $userId User Id
     * @return \MangoPay\File File object with document
     */
    public function ShareholderDeclaration($userId) {
        return $this->GetObject('users_getshareholderdeclaration', $userId, '\MangoPay\File');
    }
    
    /**
     * Create bank account for user
     * @param int $userId User Id
     * @param \MangoPay\BankAccount $bankAccount Entity of bank account object
     * @return \MangoPay\BankAccount Create bank account object
     */
    public function CreateBankAccount($userId, $bankAccount) {
        return $this->CreateObject('users_createbankaccounts', $bankAccount, '\MangoPay\BankAccount', $userId);
    }    
    
    /**
     * Get all bank accounts for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with bank account entities
     */    
    public function BankAccounts($userId, & $pagination = null) {
        return $this->GetList('users_allbankaccount', $pagination, 'MangoPay\BankAccount', $userId);
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
     * Get all wallets for user
     * @param Int/GUID $userId User identifier
     * @return array Array with mangoPay\Wallet obects returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    public function Wallets($userId, & $pagination = null) {
        return $this->GetList('users_allwallets', $pagination, 'MangoPay\Wallet', $userId);
    }
    
    /**
     * Get payment cards for user
     * @param int $userId User Id
     * @param int $paymentCardId Payment card Id
     * @return \MangoPay\PaymentCard Entity of bank account object
     */
    public function GetCards($userId, $paymentCardId) {
        return $this->GetObject('users_getpaymentcards', $userId, 'MangoPay\PaymentCard', $paymentCardId);
    }
    
    /**
     * Get all payment cards for user
     * @param int $userId User Id
     * @param \MangoPay\Pagination $pagination Pagination object
     * @return array Array with MangoPay\PaymentCard entities
     */    
    public function Cards($userId, & $pagination = null) {
        return $this->GetList('users_allpaymentcards', $pagination, 'MangoPay\PaymentCard', $userId);
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
                    return $this->CastResponseToEntity($response, '\MangoPay\UserNatural');
                case PersonType::Legal:
                    return $this->CastResponseToEntity($response, '\MangoPay\UserLegal');
                default:
                    throw new Exception('Unexpected response. Wrong PersonType value');
            }            
        } else {
            throw new Exception('Unexpected response. Missing PersonType property');
        }
    }
    
    /**
     * Get correct user object
     * @param object $response Response from API
     * @return UserLegal/UserNatural User object returned from API
     * @throws \MangoPay\Exception If occur unexpected response from API 
     */
    private function GetKycRequestResponse($response) {
        
        if (isset($response->ProofOfIdentity) || isset($response->ProofOfAddress)) {
            return $this->CastResponseToEntity($response, '\MangoPay\KYCRequestNatural');
        } elseif (isset($response->ProofOfRegistration) 
                || isset($response->Statute)
                || isset($response->ShareholderDeclaration)) {
            return $this->CastResponseToEntity($response, '\MangoPay\KYCRequestLegal');
        } else {
            throw new Exception('Unexpected response. Missing PersonType property');
        }
    }
}