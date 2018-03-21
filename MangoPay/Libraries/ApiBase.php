<?php
namespace MangoPay\Libraries;

/**
 * Base class for MangoPay API managers
 */
abstract class ApiBase
{
    /**
     * Root/parent instance that holds the OAuthToken and Configuration instance
     * @var \MangoPay\MangoPayApi
     */
    protected $_root;

    /**
     * @return mixed
     */
    protected function getLogger()
    {
        return $this->_root->getLogger();
    }

    /**
     * Array with REST url and request type
     * @var array
     */
    private $_methods = array(
        'authentication_base' => array( '/clients/', RequestType::POST ),
        'authentication_oauth' => array( '/oauth/token ', RequestType::POST ),

        'responses_get' => array( '/responses/%s', RequestType::GET),

        'events_all' => array( '/events', RequestType::GET ),

        'hooks_create' => array( '/hooks', RequestType::POST ),
        'hooks_all' => array( '/hooks', RequestType::GET ),
        'hooks_get' => array( '/hooks/%s', RequestType::GET ),
        'hooks_save' => array( '/hooks/%s', RequestType::PUT ),

        'cardregistration_create' => array( '/cardregistrations', RequestType::POST ),
        'cardregistration_get' => array( '/cardregistrations/%s', RequestType::GET ),
        'cardregistration_save' => array( '/cardregistrations/%s', RequestType::PUT ),

        'preauthorization_create' => array( '/preauthorizations/card/direct', RequestType::POST ),
        'preauthorization_get' => array( '/preauthorizations/%s', RequestType::GET ),
        'preauthorizations_get_for_card' => array( '/cards/%s/preauthorizations', RequestType::GET ),
        'preauthorizations_get_for_user' => array( '/users/%s/preauthorizations', RequestType::GET ),
        'preauthorization_save' => array( '/preauthorizations/%s', RequestType::PUT ),

        'card_get' => array( '/cards/%s', RequestType::GET ),
        'cards_get_by_fingerprint' => array('/cards/fingerprints/%s', RequestType::GET ),
        'card_save' => array( '/cards/%s', RequestType::PUT ),

        // pay ins URLs
        'payins_card-web_create' => array( '/payins/card/web/', RequestType::POST ),
        'payins_card-direct_create' => array( '/payins/card/direct/', RequestType::POST ),
        'payins_preauthorized-direct_create' => array( '/payins/preauthorized/direct/', RequestType::POST ),
        'payins_bankwire-direct_create' => array( '/payins/bankwire/direct/', RequestType::POST ),
        'payins_directdebit-web_create' => array( '/payins/directdebit/web', RequestType::POST ),
        'payins_directdebit-direct_create' => array( '/payins/directdebit/direct', RequestType::POST ),
        'payins_paypal-web_create' => array( '/payins/paypal/web', RequestType::POST ),
        'payins_get' => array( '/payins/%s', RequestType::GET ),
        'payins_createrefunds' => array( '/payins/%s/refunds', RequestType::POST ),

        'get_extended_card_view' => array( '/payins/card/web/%s/extended', RequestType::GET ),

        'payouts_bankwire_create' => array( '/payouts/bankwire/', RequestType::POST ),
        'payouts_get' => array( '/payouts/%s', RequestType::GET ),

        'refunds_get' => array( '/refunds/%s', RequestType::GET ),
        'refunds_get_for_repudiation' => array( '/repudiations/%s/refunds', RequestType::GET ),
        'refunds_get_for_transfer' => array( '/transfers/%s/refunds', RequestType::GET ),
        'refunds_get_for_payin' => array( '/payins/%s/refunds', RequestType::GET ),
        'refunds_get_for_payout' => array( '/payouts/%s/refunds', RequestType::GET ),

        'transfers_create' => array( '/transfers', RequestType::POST ),
        'transfers_get' => array( '/transfers/%s', RequestType::GET ),
        'transfers_createrefunds' => array( '/transfers/%s/refunds', RequestType::POST ),

        'users_createnaturals' => array( '/users/natural', RequestType::POST ),
        'users_createlegals' => array( '/users/legal', RequestType::POST ),

        'users_createbankaccounts_iban' => array( '/users/%s/bankaccounts/iban', RequestType::POST ),
        'users_createbankaccounts_gb' => array( '/users/%s/bankaccounts/gb', RequestType::POST ),
        'users_createbankaccounts_us' => array( '/users/%s/bankaccounts/us', RequestType::POST ),
        'users_createbankaccounts_ca' => array( '/users/%s/bankaccounts/ca', RequestType::POST ),
        'users_createbankaccounts_other' => array( '/users/%s/bankaccounts/other', RequestType::POST ),

        'users_all' => array( '/users', RequestType::GET ),
        'users_allwallets' => array( '/users/%s/wallets', RequestType::GET ),
        'users_allbankaccount' => array( '/users/%s/bankaccounts', RequestType::GET ),
        'users_allcards' => array( '/users/%s/cards', RequestType::GET ),
        'users_alltransactions' => array( '/users/%s/transactions', RequestType::GET ),
        'users_allkycdocuments' => array( '/users/%s/KYC/documents', RequestType::GET ),
        'users_allmandates' => array( '/users/%s/mandates', RequestType::GET ),
        'users_allbankaccount_mandates' => array( '/users/%s/bankaccounts/%s/mandates', RequestType::GET ),
        'users_get' => array( '/users/%s', RequestType::GET ),
        'users_getnaturals' => array( '/users/natural/%s', RequestType::GET ),
        'users_getlegals' => array( '/users/legal/%s', RequestType::GET ),
        'users_getbankaccount' => array( '/users/%s/bankaccounts/%s', RequestType::GET ),
        'users_savenaturals' => array( '/users/natural/%s', RequestType::PUT ),
        'users_savelegals' => array( '/users/legal/%s', RequestType::PUT ),
        'users_getemoney' => array( '/users/%s/emoney', RequestType::GET ),

        'bankaccounts_save' => array( '/users/%s/bankaccounts/%s', RequestType::PUT ),

        'wallets_create' => array( '/wallets', RequestType::POST ),
        'wallets_alltransactions' => array( '/wallets/%s/transactions', RequestType::GET ),
        'wallets_get' => array( '/wallets/%s', RequestType::GET ),
        'wallets_save' => array( '/wallets/%s', RequestType::PUT ),

        'kyc_documents_create' => array( '/users/%s/KYC/documents/', RequestType::POST ),
        'kyc_documents_get' => array( '/users/%s/KYC/documents/%s', RequestType::GET ),
        'kyc_documents_save' => array( '/users/%s/KYC/documents/%s', RequestType::PUT ),
        'kyc_page_create' => array( '/users/%s/KYC/documents/%s/pages', RequestType::POST ),
        'kyc_documents_all' => array( '/KYC/documents', RequestType::GET ),
        'kyc_documents_get_alt' => array( '/KYC/documents/%s', RequestType::GET ),
        'kyc_documents_create_consult' => array( '/KYC/documents/%s/consult', RequestType::POST ),

        'disputes_get' => array( '/disputes/%s', RequestType::GET),
        'disputes_save_tag' => array( '/disputes/%s', RequestType::PUT),
        'disputes_save_contest_funds' => array( '/disputes/%s/submit', RequestType::PUT),
        'dispute_save_close' => array( '/disputes/%s/close', RequestType::PUT),

        'disputes_get_transactions' => array( '/disputes/%s/transactions', RequestType::GET),

        'disputes_all' => array( '/disputes', RequestType::GET),
        'disputes_get_for_wallet' => array( '/wallets/%s/disputes', RequestType::GET),
        'disputes_get_for_user' => array( '/users/%s/disputes', RequestType::GET),

        'disputes_document_create' => array( '/disputes/%s/documents', RequestType::POST),
        'disputes_document_page_create' => array( '/disputes/%s/documents/%s/pages', RequestType::POST),
        'disputes_document_save' => array( '/disputes/%s/documents/%s', RequestType::PUT),
        'disputes_document_get' => array( '/dispute-documents/%s', RequestType::GET),
        'disputes_document_get_for_dispute' => array( '/disputes/%s/documents', RequestType::GET),
        'disputes_document_all' => array( '/dispute-documents', RequestType::GET),
        'disputes_document_create_consult' => array( '/dispute-documents/%s/consult', RequestType::POST),

        'disputes_repudiation_get' => array( '/repudiations/%s', RequestType::GET),

        'disputes_repudiation_create_settlement' => array( '/repudiations/%s/settlementtransfer', RequestType::POST),
        'disputes_repudiation_get_settlement' => array( '/settlements/%s', RequestType::GET),
        'disputes_pendingsettlement' => array('/disputes/pendingsettlement' , RequestType::GET),

        'mandates_create' => array( '/mandates/directdebit/web', RequestType::POST ),
        'mandates_save' => array( '/mandates/%s/cancel', RequestType::PUT ),
        'mandates_get' => array( '/mandates/%s', RequestType::GET ),
        'mandates_all' => array( '/mandates', RequestType::GET ),

        'client_get' => array( '/clients', RequestType::GET ),
        'client_save' => array( '/clients', RequestType::PUT ),
        'client_upload_logo' => array( '/clients/logo', RequestType::PUT ),
        'client_wallets' => array( '/clients/wallets', RequestType::GET ),
        'client_wallets_fees' => array( '/clients/wallets/fees', RequestType::GET ),
        'client_wallets_fees_currency' => array( '/clients/wallets/fees/%s', RequestType::GET ),
        'client_wallets_credit' => array( '/clients/wallets/credit', RequestType::GET ),
        'client_wallets_credit_currency' => array( '/clients/wallets/credit/%s', RequestType::GET ),
        'client_wallets_transactions' => array( '/clients/transactions', RequestType::GET ),
        'client_wallets_transactions_fees_currency' => array( '/clients/wallets/fees/%s/transactions', RequestType::GET ),
        'client_wallets_transactions_credit_currency' => array( '/clients/wallets/credit/%s/transactions', RequestType::GET ),

        'banking_aliases_iban_create' => array( '/wallets/%s/bankingaliases/iban', RequestType::POST ),
        'banking_aliases_get' => array( '/bankingaliases/%s', RequestType::GET ),
        'banking_aliases_update' => array( '/bankingaliases/%s', RequestType::PUT ),
        'banking_aliases_all' => array( '/wallets/%s/bankingaliases', RequestType::GET ),

        'reports_transactions_create' => array( '/reports/transactions', RequestType::POST ),
        'reports_wallets_create' => array( '/reports/wallets', RequestType::POST ),
        'reports_all' => array( '/reports', RequestType::GET ),
        'reports_get' => array( '/reports/%s', RequestType::GET ),

        'ubo_declaration_create' => array( '/users/legal/%s/ubodeclarations', RequestType::POST ),
        'ubo_declaration_update' => array( '/ubodeclarations/%s', RequestType::PUT ),
        'ubo_declaration_get' => array( '/ubodeclarations/%s', RequestType::GET ),

        'transactions_get_for_mandate' => array( '/mandates/%s/transactions', RequestType::GET ),
        'transactions_get_for_card' => array( '/cards/%s/transactions', RequestType::GET ),
        'transactions_get_for_bank_account' => array( '/bankaccounts/%s/transactions', RequestType::GET )

    );

    /**
     * Constructor
     * @param \MangoPay\MangoPayApi Root/parent instance that holds the OAuthToken and Configuration instance
     */
    public function __construct($root)
    {
        $this->_root = $root;
    }

    /**
     * Get URL for REST Mango Pay API
     * @param string $key Key with data
     * @return string
     */
    protected function GetRequestUrl($key)
    {
        return $this->_methods[$key][0];
    }

    /**
     * Get request type for REST Mango Pay API
     * @param string $key Key with data
     * @return RequestType
     */
    protected function GetRequestType($key)
    {
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
    protected function CreateObject($methodKey, $entity, $responseClassName = null, $entityId = null, $subEntityId = null, $idempotencyKey = null)
    {
        if (is_null($entityId)) {
            $urlMethod = $this->GetRequestUrl($methodKey);
        } elseif (is_null($subEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        } else {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $subEntityId);
        }

        $requestData = null;
        if (!is_null($entity)) {
            $requestData = $this->BuildRequestData($entity);
        }

        $rest = new RestTool(true, $this->_root);
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), $requestData, $idempotencyKey);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

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
    protected function GetObject($methodKey, $entityId, $responseClassName = null, $secondEntityId = null)
    {
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $secondEntityId);

        $rest = new RestTool(true, $this->_root);
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey));

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Get lst with entities object from API
     * @param string $methodKey Key with request data
     * @param \MangoPay\Pagination $pagination Pagination object
     * @param object $responseClassName Name of entity class from response
     * @param int $entityId Entity identifier
     * @param object $filter Object to filter data
     * @param \MangoPay\Sorting $sorting Object to sorting data
     * @return object[] Response data
     */
    protected function GetList($methodKey, & $pagination, $responseClassName = null, $entityId = null, $filter = null, $sorting = null, $secondEntityId = null)
    {
        $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId, $secondEntityId);

        if (is_null($pagination) || !is_object($pagination) || get_class($pagination) != 'MangoPay\Pagination') {
            $pagination = new \MangoPay\Pagination();
        }

        $rest = new RestTool(true, $this->_root);
        $additionalUrlParams = array();
        if (!is_null($filter)) {
            $additionalUrlParams["filter"] = $filter;
        }
        if (!is_null($sorting)) {
            if (!is_a($sorting, "\MangoPay\Sorting")) {
                throw new Exception('Wrong type of sorting object');
            }

            $additionalUrlParams["sort"] = $sorting->GetSortParameter();
        }

        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), null, null, $pagination, $additionalUrlParams);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

        return $response;
    }

    /**
     * Save object in API
     * @param string $methodKey Key with request data
     * @param object $entity Entity object to save
     * @param object $responseClassName Name of entity class from response
     * @return object Response data
     */
    protected function SaveObject($methodKey, $entity, $responseClassName = null, $secondEntityId = null)
    {
        $entityId = null;
        if (isset($entity->Id)){
            $entityId = $entity->Id;
        }

        if (is_null($secondEntityId)) {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $entityId);
        } else {
            $urlMethod = sprintf($this->GetRequestUrl($methodKey), $secondEntityId, $entityId);
        }

        $requestData = $this->BuildRequestData($entity);

        $rest = new RestTool(true, $this->_root);
        $response = $rest->Request($urlMethod, $this->GetRequestType($methodKey), $requestData);

        if (!is_null($responseClassName)) {
            return $this->CastResponseToEntity($response, $responseClassName);
        }

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
            throw new Exception('Cannot cast response to entity object. Wrong entity class name');
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

                if ($entityProperty->getName() == "DeclaredUBOs") {
                    $declaredUbos = [];
                    foreach ($value as $declaredUboRaw) {
                        $declaredUbo = new \MangoPay\DeclaredUbo();
                        $declaredUbo->UserId = $declaredUboRaw->UserId;
                        $declaredUbo->Status = $declaredUboRaw->Status;
                        $declaredUbo->RefusedReasonType = $declaredUboRaw->RefusedReasonMessage;
                        $declaredUbo->RefusedReasonMessage = $declaredUboRaw->RefusedReasonMessage;
                        array_push($declaredUbos, $declaredUbo);
                    }
                    $value = $declaredUbos;
                }

                // is sub object?
                if (isset($subObjects[$name])) {
                    if (is_null($value)) {
                        $object = null;
                    } else {
                        $object = $this->CastResponseToEntity($value, $subObjects[$name]);
                    }

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
                } else {
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
    protected function BuildRequestData($entity)
    {
        if (is_a($entity, 'MangoPay\UboDeclaration')) {
            $declaredUboIds = [];
            foreach ($entity->DeclaredUBOs as $declaredUBO) {
                if (is_string($declaredUBO)) {
                    array_push($declaredUboIds, $declaredUBO);
                } else {
                    array_push($declaredUboIds, $declaredUBO->UserId);
                }
            }
            $entity->DeclaredUBOs = $declaredUboIds;
        }
        $entityProperties = get_object_vars($entity);
        $blackList = $entity->GetReadOnlyProperties();
        $requestData = array();
        foreach ($entityProperties as $propertyName => $propertyValue) {
            if (in_array($propertyName, $blackList)) {
                continue;
            }

            if ($this->CanReadSubRequestData($entity, $propertyName)) {
                $subRequestData = $this->BuildRequestData($propertyValue);
                foreach ($subRequestData as $key => $value) {
                    $requestData[$key] = $value;
                }
            } else {
                if (isset($propertyValue)) {
                    $requestData[$propertyName] = $propertyValue;
                }
            }
        }

        if (count($requestData) == 0) {
            return new \stdClass();
        }

        return $requestData;
    }

    private function CanReadSubRequestData($entity, $propertyName)
    {
        if (get_class($entity) == 'MangoPay\PayIn' &&
                    ($propertyName == 'PaymentDetails' || $propertyName == 'ExecutionDetails')) {
            return true;
        }

        if (get_class($entity) == 'MangoPay\PayOut' && $propertyName == 'MeanOfPaymentDetails') {
            return true;
        }

        if (get_class($entity) == 'MangoPay\BankAccount' && $propertyName == 'Details') {
            return true;
        }

        return false;
    }

    protected function GetObjectForIdempotencyUrl($url){
        if (is_null($url) || empty($url))
            return null;

        $map = array(
            'preauthorization_create' => '\MangoPay\CardPreAuthorization',
            'cardregistration_create' => '\MangoPay\CardRegistration',
            'client_upload_logo' => '',
            'disputes_repudiation_create_settlement' => '\MangoPay\Transfer',
            'disputes_document_create' => '\MangoPay\DisputeDocument',
            'disputes_document_page_create' => '',
            'hooks_create' => '\MangoPay\Hook',
            'mandates_create' => '\MangoPay\Mandate',
            'payins_card-web_create' => '\MangoPay\PayIn',
            'payins_card-direct_create' => '\MangoPay\PayIn',
            'payins_preauthorized-direct_create' => '\MangoPay\PayIn',
            'payins_bankwire-direct_create' => '\MangoPay\PayIn',
            'payins_directdebit-web_create' => '\MangoPay\PayIn',
            'payins_directdebit-direct_create' => '\MangoPay\PayIn',
            'payins_createrefunds' => '\MangoPay\Refund',
            'payouts_bankwire_create' => '\MangoPay\PayOut',
            'reports_transactions_create' => '\MangoPay\ReportRequest',
            'reports_wallets_create' => '\MangoPay\ReportRequest',
            'transfers_createrefunds' => '\MangoPay\Refund',
            'transfers_create' => '\MangoPay\Transfer',
            'users_createnaturals' => '\MangoPay\UserNatural', // done
            'users_createlegals' => '\MangoPay\UserLegal',
            'users_createbankaccounts_iban' => '\MangoPay\BankAccount',
            'users_createbankaccounts_gb' => '\MangoPay\BankAccount',
            'users_createbankaccounts_us' => '\MangoPay\BankAccount',
            'users_createbankaccounts_ca' => '\MangoPay\BankAccount',
            'users_createbankaccounts_other' => '\MangoPay\BankAccount',
            'kyc_documents_create' => '\MangoPay\KycDocument',
            'kyc_page_create' => '',
            'wallets_create' => '\MangoPay\Wallet',
            'users_getemoney' => '\MangoPay\EMoney',
        );

        foreach ($map as $key => $className) {
            $sourceUrl = $this->GetRequestUrl($key);
            $sourceUrl = str_replace("%s", "[0-9a-zA-Z]*", $sourceUrl);
            $sourceUrl = str_replace("/", "\/", $sourceUrl);
            $pattern = '/' . $sourceUrl . '/';
            if (preg_match($pattern, $url) > 0) {
                return $className;
            }
        }

        return null;
    }
}
