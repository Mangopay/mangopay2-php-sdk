<?php

namespace MangoPay;

/**
 * KYC document entity
 */
class KycDocument extends Libraries\Document
{
    /**
     * The user ID who owns this document
     * @var string
     * @see \MangoPay\KycDocumentType
     */
    public $Type;

	/**
	 * The label of KYC document type
	 * @var string
	 */
	public $TypeLabel;

    /**
     * The status of the KYC document
     * @var string
     * @see \MangoPay\KycDocumentStatus
     */
    public $Status;

	/**
	 * The label of KYC document status
	 * @var string
	 */
	public $StatusLabel;

    /**
     * Refused reason type
     * @var string
     */
    public $UserId;

    /**
     * More information regarding why the document has been rejected.
     * @var array
     */
    public $Flags;
}
