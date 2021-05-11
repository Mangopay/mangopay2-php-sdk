<?php

namespace MangoPay;

/**
 * Dispute reason types
 */
class DisputeReasonType
{
    const Duplicate = "DUPLICATE";
    const Fraud = "FRAUD";
    const ProductUnacceptable = "PRODUCT_UNACCEPTABLE";
    const Unknown = "UNKNOWN";
    const Other = "OTHER";
    const RefundConversionRate = "REFUND_CONVERSION_RATE";
    const LateFailureInsufficientFunds = "LATE_FAILURE_INSUFFICIENT_FUNDS";
    const LateFailureContactUser = "LATE_FAILURE_CONTACT_USER";
    const LateFailureBankaccountClosed = "LATE_FAILURE_BANKACCOUNT_CLOSED";
    const LateFailureBankaccountIncompatible = "LATE_FAILURE_BANKACCOUNT_INCOMPATIBLE";
    const LateFailureBankaccountIncorrect = "LATE_FAILURE_BANKACCOUNT_INCORRECT";
    const AuthorisationDisputed = "AUTHORISATION_DISPUTED";
    const TransactionNotRecognized = "TRANSACTION_NOT_RECOGNIZED";
    const ProductNotProvided = "PRODUCT_NOT_PROVIDED";
    const CanceledReoccuringTransaction = "CANCELED_REOCCURING_TRANSACTION";
    const RefundNotProcessed = "REFUND_NOT_PROCESSED";
    const CounterfeitProduct = "COUNTERFEIT_PRODUCT";
}
