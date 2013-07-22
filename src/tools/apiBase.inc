<?php
namespace MangoPay;

/**
 * Base class to management MangoPay API
 */
abstract class ApiBase {
    
    /**
     * OAuth object
     * @var MangoPay\OAuth 
     */
    protected $_oauth;
    
    /**
     * Array with REST url and request type
     * @var array 
     */
    private $_methods = array(
        'authentication_base' => array( '/api/clients/', RequestType::POST ),
        'authentication_oauth' => array( '/api/oauth/token', RequestType::POST ),
        
        'users_createnaturals' => array( '/users/naturals', RequestType::POST ),
        'users_createlegals' => array( '/users/legals', RequestType::POST ),
        'users_createkycrequests' => array( '/users/%s/KYC/requests', RequestType::POST ),
        'users_createbankaccounts' => array( '/users/%s/bank-details', RequestType::POST ),
        'users_all' => array( '/users', RequestType::GET ),
        'users_allkyc' => array( '/users/%s/KYC', RequestType::GET ),
        'users_allkycrequests' => array( '/users/%s/KYC/requests', RequestType::GET ),
        'users_allwallets' => array( '/users/%s/wallets', RequestType::GET ),
        'users_allbankaccount' => array( '/users/%s/bank-details', RequestType::GET ),
        'users_allpaymentcards' => array( '/users/%s/payment-cards', RequestType::GET ),
        'users_get' => array( '/users/%s', RequestType::GET ),
        'users_getnaturals' => array( '/users/naturals/%s', RequestType::GET ),
        'users_getlegals' => array( '/users/legals/%s', RequestType::GET ),
        'users_getkycrequests' => array( '/users/%s/KYC/requests/%s', RequestType::GET ),
        'users_getproofofidentity' => array( '/users/%s/ProofOfIdentity', RequestType::GET ),
        'users_getproofofaddress' => array( '/users/%s/ProofOfAddress', RequestType::GET ),
        'users_getproofofregistration' => array( '/users/%s/ProofOfRegistration', RequestType::GET ),
        'users_getshareholderdeclaration' => array( '/users/%s/ShareholderDeclaration', RequestType::GET ),
        'users_getbankaccount' => array( '/users/%s/bank-details/%s', RequestType::GET ),
        'users_getpaymentcards' => array( '/users/%s/payment-cards/%s', RequestType::GET ),
        'users_savenaturals' => array( '/users/naturals/%s', RequestType::PUT ),
        'users_savelegals' => array( '/users/legals/%s', RequestType::PUT ),
        
        'wallets_create' => array( '/wallets', RequestType::POST ),
        'wallets_allrecurringpayinorders' => array( '/wallets/%s/recurring-pay-in-orders', RequestType::GET ),
        'wallets_alltransactions' => array( '/wallets/%s/transactions', RequestType::GET ),
        'wallets_alltransactionspage' => array( '/wallets/%s/transactions/pages/%s', RequestType::GET ),
        'wallets_get' => array( '/wallets/%s', RequestType::GET ),
        'wallets_save' => array( '/wallets/%s', RequestType::PUT ),
        
        'transfers_create' => array( '/transfers/', RequestType::POST ),
        'transfers_get' => array( '/transfers/%s', RequestType::GET ),
        'transfers_createrefunds' => array( '/transfers/%s/refunds', RequestType::POST ),
        
        // pay ins URLs
        'pay-ins_card-web_create' => array( '/pay-ins/card/web/', RequestType::POST ),
        'pay-ins_card-direct_create' => array( '/pay-ins/card/direct/', RequestType::POST ),
        'pay-ins_card-preauthorized_create' => array( '/pay-ins/card/preauthorized/', RequestType::POST ),
        'pay-ins_card-recurrentexecution_create' => array( '/pay-ins/card/recurrent-pay-in-execution/', RequestType::POST ),
        
        'pay-ins_registeredcard-web_create' => array( '/pay-ins/registered-card/web/', RequestType::POST ),
        'pay-ins_registeredcard-direct_create' => array( '/pay-ins/registered-card/direct/', RequestType::POST ),
        'pay-ins_registeredcard-preauthorized_create' => array( '/pay-ins/registered-card/preauthorized/', RequestType::POST ),
        'pay-ins_registeredcard-recurrentexecution_create' => array( '/pay-ins/registered-card/recurrent-pay-in-execution/', RequestType::POST ),
        
        'pay-ins_bankwirepayin-web_create' => array( '/pay-ins/bank-wire/web/', RequestType::POST ),
        'pay-ins_bankwirepayin-direct_create' => array( '/pay-ins/bank-wire/direct/', RequestType::POST ),
        'pay-ins_bankwirepayin-preauthorized_create' => array( '/pay-ins/bank-wire/preauthorized/', RequestType::POST ),
        'pay-ins_bankwirepayin-recurrentexecution_create' => array( '/pay-ins/bank-wire/recurrent-pay-in-execution/', RequestType::POST ),
        
        'pay-ins_directcredit-web_create' => array( '/pay-ins/direct-credit/web/', RequestType::POST ),
        'pay-ins_directcredit-direct_create' => array( '/pay-ins/direct-credit/direct/', RequestType::POST ),
        'pay-ins_directcredit-preauthorized_create' => array( '/pay-ins/direct-credit/preauthorized/', RequestType::POST ),
        'pay-ins_directcredit-recurrentexecution_create' => array( '/pay-ins/direct-credit/recurrent-pay-in-execution/', RequestType::POST ),
        'pay-ins_get' => array( '/pay-ins/%s', RequestType::GET ),
        'pay-ins_createrefunds' => array( '/pay-ins/%s/refunds', RequestType::POST ),
                
        'cross-currency-transfers_create' => array( '/transfers/%s', RequestType::POST ),
        'cross-currency-transfers_get' => array( '/transfers/%s', RequestType::GET ),
        
        'pay-outs_bankwirepayout_create' => array( '/pay-outs/bank-wire/', RequestType::POST ),
        'pay-outs_merchantexpense_create' => array( '/pay-outs/merchant-expense/', RequestType::POST ),
        'pay-outs_amazongiftcard_create' => array( '/pay-outs/bank-wire/', RequestType::POST ),
        'pay-outs_get' => array( '/pay-outs/%s', RequestType::GET ),
        'pay-outs_createrefunds' => array( '/pay-outs/%s/refunds', RequestType::POST ),
        
        'refunds_get' => array( '/refunds/%s', RequestType::GET ),
    );
    
    /**
     * Constructor
     * @param OAuth $oauth OAuth object with data to authentication
     */
    function __construct($oauth = null) {
        $this->_oauth = $oauth;
    }
    
    /**
     * Get URL for REST Mango Pay API
     * @param string $key Key with data
     * @return string 
     */
    protected function GetRequestUrl($key){
        return $this->_methods[$key][0];
    }
    
    /**
     * Get request type for REST Mango Pay API
     * @param string $key Key with data
     * @return RequestType 
     */
    protected function GetRequestType($key){
        return $this->_methods[$key][1];
    }
    
    /**
     * Create object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object
     * @param object $responseClassName Name of entity class from response
     * @param int $entityId Entity identifier
     * @return object Respons data
     */
    protected function CreateObject($methodKey, $entity, $responseClassName = null, $entityId = null) {
        
        if (is_null($entityId))
            $urlMethod = $this->GetRequestUrl($methodKey);
        else
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        
        $requestData = null;
        if (!is_null($entity))
            $requestData = $this->BuildRequestData($entity);
        
        $rest = $this->GetRestToolObject();
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), $requestData);
        
        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);
        
        return $response;
    }
    
    /**
     * Get entity object from API
     * @param string $methodKey Key with request data
     * @param int $entityId Entity identifier
     * @param object $responseClassName Name of entity class from response
     * @param int $secondEntityId Entity identifier for second entity
     * @return object Respons data
     */
    protected function GetObject($methodKey, $entityId, $responseClassName = null, $secondEntityId = null) {
        
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $secondEntityId);
        
        $rest = $this->GetRestToolObject();
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey));
        
        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);
        
        return $response;
    }
    
    /**
     * Get lst with entities object from API
     * @param string $methodKey Key with request data
     * @param MangoPay\Pagination $pagination Pagination object
     * @param object $responseClassName Name of entity class from response
     * @param int $entityId Entity identifier
     * @return object Respons data
     */
    protected function GetList($methodKey, & $pagination, $responseClassName = null, $entityId = null) {
        
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        
        if (is_null($pagination) || !is_object($pagination) || get_class($pagination) != 'MangoPay\Pagination') {
            $pagination = new Pagination();
        }
        
        $rest = $this->GetRestToolObject();
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), null, $pagination);
        
        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);
        
        return $response;
    }
    
    /**
     * Save object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object to save
     * @param object $responseClassName Name of entity class from response
     * @return object Respons data
     */
    protected function SaveObject($methodKey, $entity, $responseClassName = null) {
        
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entity->Id);
        $requestData = $this->BuildRequestData($entity);
        
        $rest = $this->GetRestToolObject();
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), $requestData);
        
        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);
        
        return $response;
    }
    
    /**
     * Get RestTool object 
     * @param bool $authRequired Variable to flag that in request the authentication data are required
     * @return \MangoPay\RestTool RestTool object
     */
    protected function GetRestToolObject($authRequired = true) {
        return new RestTool($authRequired, $this->_oauth);
    }
    
    /**
     * Cast response object to entity object
     * @param object $response Object from API response
     * @param string $entityClassName Name of entity class to cast
     * @return \MangoPay\$entityClassName Return entity object
     */
    protected function CastResponseToEntity($response, $entityClassName)
    {
        if (is_array($response)) {
            
            $list = array();
            foreach ($response as $reponseObject) {
                array_push($list, $this->CastResponseToEntity($reponseObject, $entityClassName));
            }
            
            return $list;
        }
        
        if (is_string($entityClassName)) {
            $entity = new $entityClassName();
        } else {
            throw new Exception('Cannot cast response to entity object. Wrong entity class name');
        }
        
        $responseReflection = new \ReflectionObject($response);
        $entityReflection = new \ReflectionObject($entity);
        $responseProperties = $responseReflection->getProperties();
        
        foreach ($responseProperties as $responseProperty) {
            
            $responseProperty->setAccessible(true);
            
            $name = $responseProperty->getName();
            $value = $responseProperty->getValue($response);
            
            if ($entityReflection->hasProperty($name)) {
                
                $entityProperty = $entityReflection->getProperty($name);
                $entityProperty->setAccessible(true);
                
                // get sub objects
                $subObjects = null;
                if ($entityReflection->hasMethod('GetSubObjects')) {
                    $entityGetSubObjects = $entityReflection->getMethod('GetSubObjects');
                    $entityGetSubObjects->setAccessible(true);
                    $subObjects = $entityGetSubObjects->invoke($entity);
                }
               
                if (is_array($subObjects) && isset($subObjects[$name])) {
                    $object = $this->CastResponseToEntity($value, $subObjects[$name]);
                    $entityProperty->setValue($entity, $object);
                } else {
                    $entityProperty->setValue($entity, $value);
                }
                
                // get depends objects
                $dependsObjects = null;
                if ($entityReflection->hasMethod('GetDependsObjects')) {
                    $entityGetDependsObjects = $entityReflection->getMethod('GetDependsObjects');
                    $entityGetDependsObjects->setAccessible(true);
                    $dependsObjects = $entityGetDependsObjects->invoke($entity);
                }
                
                if (is_array($dependsObjects) && isset($dependsObjects[$name])) {
                    $subObject = $subObjects[$name];
                    $entityDependProperty = $entityReflection->getProperty($subObject['_property_name']);
                    $entityDependProperty->setAccessible(true);
                    $entityDependProperty->setValue($entity, $this->CastResponseToEntity($response, $subObject[$value]));    
                }
            } else {
                throw new Exception('Cannot cast response to entity object. Missing property ' . $name .' in entity ' . $entityClassName);
            }
        }
        
        return $entity;
    }
    
    /**
     * Get array with request data
     * @param object $entity Entity object to send as request data
     * @return array 
     */
    protected function BuildRequestData($entity) {
        
        $entityProperies = get_object_vars($entity);
        $requestData = array();
        foreach ($entityProperies as $propertyName => $propertyValue) {
            if (isset($propertyValue))
                $requestData[$propertyName] = $propertyValue;
        }
        
        return $requestData;
    }
}