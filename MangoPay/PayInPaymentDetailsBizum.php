<?php

namespace MangoPay;

/**
 * Class represents Bizum type for mean of payment in Bizum entity
 */
class PayInPaymentDetailsBizum extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The phone number of the end user to which the Bizum push notification is sent to authenticate the transaction.
     * On Bizum, if the Phone parameter is sent, then RedirectURL is not returned and ReturnURL not required.
     * @var string
     */
    public $Phone;

    /**
     * Custom description to show on the user's bank statement.
     * It can be up to 10 char alphanumeric and space.
     * @var string
     */
    public $StatementDescriptor;
}
