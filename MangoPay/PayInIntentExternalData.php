<?php

namespace MangoPay;

class PayInIntentExternalData extends Libraries\Dto
{
    /**
     * The date at which the transaction was created
     * @var string
     */
    public $ExternalProcessingDate;

    /**
     * The unique identifier of the transaction at the provider level
     * @var string
     */
    public $ExternalProviderReference;

    /**
     * The unique identifier of the transaction at the merchant level
     * @var string
     */
    public $ExternalMerchantReference;

    /**
     * The name of the external provider processing the transaction
     * @var string
     */
    public $ExternalProviderName;

    /**
     * The name of the payment method used to process the transaction
     * @var string
     */
    public $ExternalProviderPaymentMethod;
}
