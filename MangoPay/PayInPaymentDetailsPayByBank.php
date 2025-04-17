<?php

namespace MangoPay;

/**
 * Class represents PayByBank type for mean of payment in PayByBank entity
 */
class PayInPaymentDetailsPayByBank extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Custom description to appear on the user’s bank statement along with the platform name.
     * Different banks may show more or less information
     * @var string
     */
    public $StatementDescriptor;

    /**
     * The country of residence of the user.
     * @var string
     */
    public $Country;

    /**
     * The BIC of the user’s bank account, which is only returned if it was sent.
     *
     * If both the IBAN and BIC are provided, one of the two authentication steps required by certain banks may be avoided.
     * @var string
     */
    public $BIC;

    /**
     * The IBAN of the user’s bank account, which is only returned if it was sent.
     *
     * If both the IBAN and BIC are provided, one of the two authentication steps required by certain banks may be avoided.
     * @var string
     */
    public $IBAN;

    /**
     * The platform environment of the post-payment flow.
     * The PaymentFlow value combines with the ReturnURL to manage the redirection behavior after payment:
     *
     * - WEB: For web browser usage(default setting)
     *
     * - APP: For mobile application usage
     *
     * In both cases you need to provide the relevant ReturnURL, whether to your app or website.
     *
     * @var string
     */
    public $PaymentFlow;

    /**
     * Name of the end-user’s bank
     * @var string
     */
    public $BankName;

    /**
     * The scheme to use to process the payment. Note that some banks may charge additional fees
     * to the user for instant payment schemes.
     *
     * Please note that the scheme is mandatory for the Danish market (”Country” : “DK”)
     *
     * @var string
     */
    public $Scheme;

    /**
     * Parameter that is only returned once the bank wire has been successfully authenticated and initiated by the user
     * but has not yet been received by Mangopay. When the funds are received, the Status changes from CREATED to
     * SUCCEEDED and the ProcessingStatus is no longer returned.
     *
     * For non-instant schemes, processing can take up to 72 hours but is typically completed within 2 days.
     *
     * Possible value: PENDING_SUCCEEDED
     *
     * @var string
     */
    public $ProcessingStatus;
}
