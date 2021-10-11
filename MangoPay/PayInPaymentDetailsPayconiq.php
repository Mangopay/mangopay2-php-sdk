<?php

namespace MangoPay;

/**
 * Class represents Payconiq type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsPayconiq extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * The country of your user (should be BE, NL or LU)
     * @var $Country
     */
    public $Country;

    public $DebitedWalletId;

    public $DeepLinkURL;

    public $ExpirationDate;
}
