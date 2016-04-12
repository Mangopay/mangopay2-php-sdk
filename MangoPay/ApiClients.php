<?php
namespace MangoPay;

/**
 * Class to management MangoPay API for users
 */
class ApiClients extends Libraries\ApiBase
{
    /**
     * Get client data for Basic Access Authentication
     * @param string $clientId Client identifier
     * @param string $clientName Beautiful name for presentation
     * @param string $clientEmail Client's email
     * @return \MangoPay\Client Client object
     */
    public function Create($clientId, $clientName, $clientEmail)
    {
        $urlMethod = $this->GetRequestUrl('authentication_base');
        $requestType = $this->GetRequestType('authentication_base');
        $requestData = array(
            'ClientId' => $clientId,
            'Name' => $clientName,
            'Email' => $clientEmail,
        );
        
        $rest = new Libraries\RestTool(false, $this->_root);
        $response = $rest->Request($urlMethod, $requestType, $requestData);
        return $this->CastResponseToEntity($response, '\MangoPay\Client');
    }
    
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
}
