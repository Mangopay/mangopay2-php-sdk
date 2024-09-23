<?php

namespace MangoPay;

/**
 * Class represents Bancontact type for mean of payment in Bancontact entity
 */
class PayInPaymentDetailsBancontact extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The URL where you should redirect your client in a mobile app experience
     * @var string
     */
    public $DeepLinkURL;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;

    /**
     * Whether the Bancontact pay-ins are being made to be re-used in a recurring payment flow
     * @var boolean
     */
    public $Recurring;
}
