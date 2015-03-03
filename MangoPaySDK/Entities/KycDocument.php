<?php
namespace MangoPay\Entities;

/**
 * KYC document entity
 */
class KycDocument extends EntityBase {

    /**
     * Document type
     * @var \MangoPay\Entities\KycDocumentType
     */
    public $Type;

    /**
     * Document status
     * @var \MangoPay\Entities\KycDocumentStatus
     */
    public $Status;

    /**
     * Refused reason type
     * @var type string
     */
    public $RefusedReasonType;

    /**
     * Refused reason message
     * @var type string
     */
    public $RefusedReasonMessage;

    /**
     * User identifier
     * @var type string
     */
    public $UserId;
}
