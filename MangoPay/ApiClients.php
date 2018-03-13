<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiClients extends Libraries\ApiBase
{
    /**
     * Get client information
     * 
     * @return \MangoPay\Client Client object returned from API
     */
    public function Get()
    {
        return $this->GetObject('client_get', null, '\MangoPay\Client');
    }
    
    /**
     * Save client
     * @param Client $client Client object to save
     * @return \MangoPay\Client Client object returned from API
     */
    public function Update($client)
    {
        if (!is_null($client->HeadquartersAddress) 
            && is_a($client->HeadquartersAddress, "MangoPay\Address")
            && $client->HeadquartersAddress->CanBeNull()) {
                    $client->HeadquartersAddress = null;
        }
            
        return $this->SaveObject('client_save', $client, '\MangoPay\Client');
    }
    
    /**
     * Upload a logo for client.
     * Only GIF, PNG, JPG, JPEG, BMP, PDF and DOC formats are accepted, 
     * and file must be less than about 7MB
     * @param \MangoPay\ClientLogoUpload $logo ClientLogoUpload object
     */
    public function UploadLogo($logoUpload, $idempotencyKey = null)
    {
        try {
            $this->CreateObject('client_upload_logo', $logoUpload, null, null, null, $idempotencyKey);
        } catch (\MangoPay\Libraries\ResponseException $exc) {
            if ($exc->getCode() != 204) {
                throw $exc;
            }
        }
    }
    
    /**
     * Upload a logo for client from file.
     * Only GIF, PNG, JPG, JPEG, BMP, PDF and DOC formats are accepted, 
     * and file must be less than about 7MB
     * @param string $file Path of file with logo
     * @throws \MangoPay\Libraries\Exception
     */
    public function UploadLogoFromFile($file, $idempotencyKey = null)
    {
        $filePath = $file;
        if (is_array($file)) {
            $filePath = $file['tmp_name'];
        }
        
        if (empty($filePath)) {
            throw new \MangoPay\Libraries\Exception('Path of file cannot be empty');
        }
        
        if (!file_exists($filePath)) {
            throw new \MangoPay\Libraries\Exception('File not exist');
        }
        
        $logoUpload = new \MangoPay\ClientLogoUpload();
        $logoUpload->File = base64_encode(file_get_contents($filePath));
        
        if (empty($logoUpload->File)) {
            throw new \MangoPay\Libraries\Exception('Content of the file cannot be empty');
        }
        
        $this->UploadLogo($logoUpload, $idempotencyKey);
    }
    
    /**
     * View your client wallets. To see your fees or credit wallets 
     * for each currency set second $fundsType parameter.
     * 
     * @param \MangoPay\FundsType $fundsType FundsType enum
     * @param \MangoPay\Sorting $sorting Sorting object
     *  
     * @return \MangoPay\Wallet[] List with your client wallets
     */
    public function GetWallets($fundsType = null, $sorting = null)
    {
        $pagination = new \MangoPay\Pagination();

        if (is_null($fundsType)){
            return $this->GetList('client_wallets', $pagination, '\MangoPay\Wallet', null, null, $sorting);
        } else if ($fundsType == FundsType::FEES){
            return $this->GetList('client_wallets_fees', $pagination, '\MangoPay\Wallet', null, null, $sorting);
        } else if ($fundsType == FundsType::CREDIT){
            return $this->GetList('client_wallets_credit', $pagination, '\MangoPay\Wallet', null, null, $sorting);
        }
        
        throw new \MangoPay\Libraries\Exception('\MangoPay\FundsType object has wrong value and cannot get wallets'); 
    }
    
    /**
     * View one of your client wallets (fees or credit) with a particular currency.
     * 
     * @param \MangoPay\FundsType $fundsType FundsType enum
     * @param \MangoPay\CurrencyIso $currencyIso CurrencyIso enum
     * 
     * @return \MangoPay\Wallet Wallets (fees or credit) with a particular currency
     */
    public function GetWallet($fundsType, $currencyIso)
    {        
        if (is_null($fundsType)){
            throw new \MangoPay\Libraries\Exception(
                    'First parameter in function GetWallet in class ApiClients is required.');
        }
        
        if (is_null($currencyIso)){
            throw new \MangoPay\Libraries\Exception(
                    'Second parameter in function GetWallet in class ApiClients is required.');
        }
        
        $methodKey = null;
        if ($fundsType == FundsType::FEES){
            $methodKey = 'client_wallets_fees_currency';
        } else if ($fundsType == FundsType::CREDIT){
            $methodKey = 'client_wallets_credit_currency';
        } else {
            throw new \MangoPay\Libraries\Exception('\MangoPay\FundsType object has wrong value and cannot get wallets'); 
        }
        
        return $this->GetObject($methodKey, $currencyIso, '\MangoPay\Wallet');       
    }
    
    /**
     * View the transactions linked to your client wallets (fees and credit)
     * 
     * @param \MangoPay\FundsType $fundsType FundsType enum
     * @param \MangoPay\CurrencyIso $currencyIso CurrencyIso enum
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param \MangoPay\FilterTransactions $filter Object to filter data
     * 
     * @return \MangoPay\Transaction[] Transactions linked to your client wallets (fees and credit)
     */
    public function GetWalletTransactions($fundsType = null, $currencyIso = null, & $pagination = null, $filter = null)
    {
        if (is_null($fundsType)){
            $methodKey = 'client_wallets_transactions';
        } else if ($fundsType == FundsType::FEES){
            $methodKey = 'client_wallets_transactions_fees_currency';
        } else if ($fundsType == FundsType::CREDIT){
            $methodKey = 'client_wallets_transactions_credit_currency';
        } else {
            throw new \MangoPay\Libraries\Exception(
                     '\MangoPay\FundsType object has wrong value.');
        }
        
        if (!is_null($fundsType) && is_null($currencyIso)){
             throw new \MangoPay\Libraries\Exception(
                     'If FundsType is defined the second parameter (currency) is required.');
        }
        
        return $this->GetList($methodKey, $pagination, '\MangoPay\Transaction', $currencyIso, $filter, null);
    }
}
