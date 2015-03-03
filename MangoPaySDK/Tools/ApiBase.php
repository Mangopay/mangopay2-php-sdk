<?php
namespace MangoPay\Tools;

use MangoPay\Enums;

/**
 * Base class for MangoPay API managers
 */
abstract class ApiBase {

    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    protected $_root;

    /**
     * Array with REST url and request type
     * @var array
     */
    private $_methods = array(
        'authentication_base' => array( '/api/clients/', Enums\RequestType::POST ),
        'authentication_oauth' => array( '/oauth/token ', Enums\RequestType::POST ),

        'events_all' => array( '/events', Enums\RequestType::GET ),

        'hooks_create' => array( '/hooks', Enums\RequestType::POST ),
        'hooks_all' => array( '/hooks', Enums\RequestType::GET ),
        'hooks_get' => array( '/hooks/%s', Enums\RequestType::GET ),
        'hooks_save' => array( '/hooks/%s', Enums\RequestType::PUT ),

        'cardregistration_create' => array( '/cardregistrations', Enums\RequestType::POST ),
        'cardregistration_get' => array( '/cardregistrations/%s', Enums\RequestType::GET ),
        'cardregistration_save' => array( '/cardregistrations/%s', Enums\RequestType::PUT ),

        'preauthorization_create' => array( '/preauthorizations/card/direct', Enums\RequestType::POST ),
        'preauthorization_get' => array( '/preauthorizations/%s', Enums\RequestType::GET ),
        'preauthorization_save' => array( '/preauthorizations/%s', Enums\RequestType::PUT ),

        'card_get' => array( '/cards/%s', Enums\RequestType::GET ),
        'card_save' => array( '/cards/%s', Enums\RequestType::PUT ),

        // pay ins URLs
        'payins_card-web_create' => array( '/payins/card/web/', Enums\RequestType::POST ),
        'payins_card-direct_create' => array( '/payins/card/direct/', Enums\RequestType::POST ),
        'payins_preauthorized-direct_create' => array( '/payins/preauthorized/direct/', Enums\RequestType::POST ),
        'payins_bankwire-direct_create' => array( '/payins/bankwire/direct/', Enums\RequestType::POST ),
        'payins_directdebit-web_create' => array( '/payins/directdebit/web', Enums\RequestType::POST ),
        'payins_get' => array( '/payins/%s', Enums\RequestType::GET ),
        'payins_createrefunds' => array( '/payins/%s/refunds', Enums\RequestType::POST ),

        'payouts_bankwire_create' => array( '/payouts/bankwire/', Enums\RequestType::POST ),
        'payouts_get' => array( '/payouts/%s', Enums\RequestType::GET ),

        'refunds_get' => array( '/refunds/%s', Enums\RequestType::GET ),

        'transfers_create' => array( '/transfers', Enums\RequestType::POST ),
        'transfers_get' => array( '/transfers/%s', Enums\RequestType::GET ),
        'transfers_createrefunds' => array( '/transfers/%s/refunds', Enums\RequestType::POST ),

        'users_createnaturals' => array( '/users/natural', Enums\RequestType::POST ),
        'users_createlegals' => array( '/users/legal', Enums\RequestType::POST ),

        'users_createbankaccounts_iban' => array( '/users/%s/bankaccounts/iban', Enums\RequestType::POST ),
        'users_createbankaccounts_gb' => array( '/users/%s/bankaccounts/gb', Enums\RequestType::POST ),
        'users_createbankaccounts_us' => array( '/users/%s/bankaccounts/us', Enums\RequestType::POST ),
        'users_createbankaccounts_ca' => array( '/users/%s/bankaccounts/ca', Enums\RequestType::POST ),
        'users_createbankaccounts_other' => array( '/users/%s/bankaccounts/other', Enums\RequestType::POST ),

        'users_all' => array( '/users', Enums\RequestType::GET ),
        'users_allwallets' => array( '/users/%s/wallets', Enums\RequestType::GET ),
        'users_allbankaccount' => array( '/users/%s/bankaccounts', Enums\RequestType::GET ),
        'users_allcards' => array( '/users/%s/cards', Enums\RequestType::GET ),
        'users_alltransactions' => array( '/users/%s/transactions', Enums\RequestType::GET ),
        'users_allkycdocuments' => array( '/users/%s/KYC/documents', Enums\RequestType::GET ),
        'users_get' => array( '/users/%s', Enums\RequestType::GET ),
        'users_getnaturals' => array( '/users/natural/%s', Enums\RequestType::GET ),
        'users_getlegals' => array( '/users/legal/%s', Enums\RequestType::GET ),
        'users_getbankaccount' => array( '/users/%s/bankaccounts/%s', Enums\RequestType::GET ),
        'users_savenaturals' => array( '/users/natural/%s', Enums\RequestType::PUT ),
        'users_savelegals' => array( '/users/legal/%s', Enums\RequestType::PUT ),

        'wallets_create' => array( '/wallets', Enums\RequestType::POST ),
        'wallets_alltransactions' => array( '/wallets/%s/transactions', Enums\RequestType::GET ),
        'wallets_get' => array( '/wallets/%s', Enums\RequestType::GET ),
        'wallets_save' => array( '/wallets/%s', Enums\RequestType::PUT ),

        'kyc_documents_create' => array( '/users/%s/KYC/documents/', Enums\RequestType::POST ),
        'kyc_documents_get' => array( '/users/%s/KYC/documents/%s', Enums\RequestType::GET ),
        'kyc_documents_save' => array( '/users/%s/KYC/documents/%s', Enums\RequestType::PUT ),
        'kyc_page_create' => array( '/users/%s/KYC/documents/%s/pages', Enums\RequestType::POST ),
        'kyc_documents_all' => array( '/KYC/documents', Enums\RequestType::GET ),

        // These are temporary functions and WILL be removed in the future.
        // Please, contact with support before using these features or if you have any questions.
        'temp_paymentcards_create' => array( '/temp/paymentcards', Enums\RequestType::POST ),
        'temp_paymentcards_get' => array( '/temp/paymentcards/%s', Enums\RequestType::GET ),
        'temp_immediatepayins_create' => array( '/temp/immediate-payins', Enums\RequestType::POST )
    );

    /**
     * Constructor
     * @param \MangoPay\MangoPayApi Root/parent instance that holds the OAuthToken and Configuration instance
     */
    function __construct($root) {
        $this->_root = $root;
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
     * @return object Response data
     */
    protected function CreateObject($methodKey, $entity, $responseClassName = null, $entityId = null, $subEntityId = null) {

        if (is_null($entityId))
            $urlMethod = $this->GetRequestUrl($methodKey);
        elseif (is_null($subEntityId))
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        else
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $subEntityId);

        $requestData = null;
        if (!is_null($entity))
            $requestData = $this->BuildRequestData($entity);

        $rest = new RestTool(true, $this->_root);
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
     * @return object Response data
     */
    protected function GetObject($methodKey, $entityId, $responseClassName = null, $secondEntityId = null) {

        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $secondEntityId);

        $rest = new RestTool(true, $this->_root);
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey));

        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);

        return $response;
    }

    /**
     * Get lst with entities object from API
     * @param string $methodKey Key with request data
     * @param \MangoPay\Types\Pagination $pagination Pagination object
     * @param object $responseClassName Name of entity class from response
     * @param int $entityId Entity identifier
     * @param object $filter Object to filter data
     * @return object Response data
     */
    protected function GetList($methodKey, & $pagination, $responseClassName = null, $entityId = null, $filter = null, $sorting = null) {

        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);

        if (is_null($pagination) || !is_object($pagination) || get_class($pagination) != 'MangoPay\Types\Pagination') {
            $pagination = new \MangoPay\Types\Pagination();
        }

        $rest = new RestTool(true, $this->_root);
        $additionalUrlParams = array();
        if (!is_null($filter))
            $additionalUrlParams["filter"] = $filter;
        if (!is_null($sorting)){
            if (!is_a($sorting, "\MangoPay\Tools\Sorting"))
                throw new Exception('Wrong type of sorting object');

            $additionalUrlParams["sort"] = $sorting->GetSortParameter();
        }

        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), null, $pagination, $additionalUrlParams);

        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);

        return $response;
    }

    /**
     * Save object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object to save
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     */
    protected function SaveObject($methodKey, $entity, $responseClassName = null, $secondEntityId = null) {

        if (is_null($secondEntityId))
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entity->Id);
        else
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $secondEntityId, $entity->Id);

        $requestData = $this->BuildRequestData($entity);

        $rest = new RestTool(true, $this->_root);
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), $requestData);

        if (!is_null($responseClassName))
            return $this->CastResponseToEntity($response, $responseClassName);

        return $response;
    }

    /**
     * Cast response object to entity object
     * @param object $response Object from API response
     * @param string $entityClassName Name of entity class to cast
     * @return \MangoPay\$entityClassName Return entity object
     */
    protected function CastResponseToEntity($response, $entityClassName, $asDependentObject = false)
    {
        if (is_array($response)) {

            $list = array();
            foreach ($response as $responseObject) {
                array_push($list, $this->CastResponseToEntity($responseObject, $entityClassName));
            }

            return $list;
        }

        if (is_string($entityClassName)) {
            $entity = new $entityClassName();
        } else {
            throw new \MangoPay\Types\Exceptions\Exception('Cannot cast response to entity object. Wrong entity class name');
        }

        $responseReflection = new \ReflectionObject($response);
        $entityReflection = new \ReflectionObject($entity);
        $responseProperties = $responseReflection->getProperties();

        $subObjects = $entity->GetSubObjects();
        $dependsObjects = $entity->GetDependsObjects();

        foreach ($responseProperties as $responseProperty) {

            $responseProperty->setAccessible(true);

            $name = $responseProperty->getName();
            $value = $responseProperty->getValue($response);

            if ($entityReflection->hasProperty($name)) {

                $entityProperty = $entityReflection->getProperty($name);
                $entityProperty->setAccessible(true);

                // is sub object?
                if (isset($subObjects[$name])) {
                    if (is_null($value))
                        $object = null;
                    else
                        $object = $this->CastResponseToEntity($value, $subObjects[$name]);

                    $entityProperty->setValue($entity, $object);
                } else {
                    $entityProperty->setValue($entity, $value);
                }

                // has dependent object?
                if (isset($dependsObjects[$name])) {
                    $dependsObject = $dependsObjects[$name];
                    $entityDependProperty = $entityReflection->getProperty($dependsObject['_property_name']);
                    $entityDependProperty->setAccessible(true);
                    $entityDependProperty->setValue($entity, $this->CastResponseToEntity($response, $dependsObject[$value], true));
                }
            } else {
                if ($asDependentObject || !empty($dependsObjects)) {
                    continue;
                }
                else {
					/* UNCOMMENT THE LINE BELOW TO ENABLE RESTRICTIVE REFLECTION MODE */
					//throw new Exception('Cannot cast response to entity object. Missing property ' . $name .' in entity ' . $entityClassName);

					continue;
				}
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

        $entityProperties = get_object_vars($entity);
        $blackList = $entity->GetReadOnlyProperties();
        $requestData = array();
        foreach ($entityProperties as $propertyName => $propertyValue) {

            if (in_array($propertyName, $blackList))
                continue;

            if ($this->CanReadSubRequestData($entity, $propertyName)) {
                $subRequestData = $this->BuildRequestData($propertyValue);
                foreach ($subRequestData as $key => $value) {
                    $requestData[$key] = $value;
                }
            } else {
                if (isset($propertyValue))
                    $requestData[$propertyName] = $propertyValue;
            }
        }

        return $requestData;
    }

    private function CanReadSubRequestData($entity, $propertyName) {
        if (get_class($entity) == 'MangoPay\Entities\PayIn' &&
                    ($propertyName == 'PaymentDetails' || $propertyName == 'ExecutionDetails')) {
            return true;
        }

        if (get_class($entity) == 'MangoPay\Entities\PayOut' && $propertyName == 'MeanOfPaymentDetails') {
            return true;
        }

        if (get_class($entity) == 'MangoPay\Entities\BankAccount' && $propertyName == 'Details' ) {
            return true;
        }

        return false;
    }
}
