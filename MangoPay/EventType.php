<?php

namespace MangoPay;

/**
 * Event types
 */
class EventType
{
    public const KycCreated = "KYC_CREATED";
    public const KycSucceeded = "KYC_SUCCEEDED";
    public const KycFailed = "KYC_FAILED";
    public const KycOutdated = "KYC_OUTDATED";
    public const KycValidationAsked  = "KYC_VALIDATION_ASKED";
    public const PayinNormalCreated = "PAYIN_NORMAL_CREATED";
    public const PayinNormalSucceeded = "PAYIN_NORMAL_SUCCEEDED";
    public const PayinNormalFailed = "PAYIN_NORMAL_FAILED";
    public const PayoutNormalCreated = "PAYOUT_NORMAL_CREATED";
    public const PayoutNormalSucceeded = "PAYOUT_NORMAL_SUCCEEDED";
    public const PayoutNormalFailed = "PAYOUT_NORMAL_FAILED";
    public const TransferNormalCreated = "TRANSFER_NORMAL_CREATED";
    public const TransferNormalSucceeded = "TRANSFER_NORMAL_SUCCEEDED";
    public const TransferNormalFailed = "TRANSFER_NORMAL_FAILED";
    public const PayinRefundCreated = "PAYIN_REFUND_CREATED";
    public const PayinRefundSucceeded = "PAYIN_REFUND_SUCCEEDED";
    public const PayinRefundFailed = "PAYIN_REFUND_FAILED";
    public const PayoutRefundCreated = "PAYOUT_REFUND_CREATED";
    public const PayoutRefundSucceeded = "PAYOUT_REFUND_SUCCEEDED";
    public const PayoutRefundFailed = "PAYOUT_REFUND_FAILED";
    public const TransferRefundCreated = "TRANSFER_REFUND_CREATED";
    public const TransferRefundSucceeded = "TRANSFER_REFUND_SUCCEEDED";
    public const TransferRefundFailed = "TRANSFER_REFUND_FAILED";
    public const PayinRepudiationCreated = "PAYIN_REPUDIATION_CREATED";
    public const PayinRepudiationSucceeded = "PAYIN_REPUDIATION_SUCCEEDED";
    public const PayinRepudiationFailed = "PAYIN_REPUDIATION_FAILED";
    public const DisputeDocumentCreated = "DISPUTE_DOCUMENT_CREATED";
    public const DisputeDocumentValidationAsked = "DISPUTE_DOCUMENT_VALIDATION_ASKED";
    public const DisputeDocumentSucceeded = "DISPUTE_DOCUMENT_SUCCEEDED";
    public const DisputeDocumentFailed = "DISPUTE_DOCUMENT_FAILED";
    public const DisputeCreated = "DISPUTE_CREATED";
    public const DisputeSubmitted = "DISPUTE_SUBMITTED";
    public const DisputeActionRequired = "DISPUTE_ACTION_REQUIRED";
    public const DisputeFurtherActionRequired = "DISPUTE_FURTHER_ACTION_REQUIRED";
    public const DisputeClosed = "DISPUTE_CLOSED";
    public const DisputeSentToBank = "DISPUTE_SENT_TO_BANK";
    public const TransferSettlementCreated = "TRANSFER_SETTLEMENT_CREATED";
    public const TransferSettlementSucceeded = "TRANSFER_SETTLEMENT_SUCCEEDED";
    public const TransferSettlementFailed = "TRANSFER_SETTLEMENT_FAILED";
    public const MandateCreated = "MANDATE_CREATED";
    //MandatedFailed typo to be deprecated, typo fixed.
    public const MandatedFailed = "MANDATE_FAILED";
    public const MandateFailed = "MANDATE_FAILED";
    public const MandateActivated = "MANDATE_ACTIVATED";
    public const MandateSubmitted = "MANDATE_SUBMITTED";
    public const MandateExpired = "MANDATE_EXPIRED";
    public const PreAuthorizationPaymentWaiting = "PREAUTHORIZATION_PAYMENT_WAITING";
    public const PreAuthorizationPaymentExpired = "PREAUTHORIZATION_PAYMENT_EXPIRED";
    public const PreAuthorizationPaymentCanceled = "PREAUTHORIZATION_PAYMENT_CANCELED";
    public const PreAuthorizationPaymentValidated = "PREAUTHORIZATION_PAYMENT_VALIDATED";
    public const UboDeclarationCreated = "UBO_DECLARATION_CREATED";
    public const UboDeclarationValidationAsked = "UBO_DECLARATION_VALIDATION_ASKED";
    public const UboDeclarationRefused = "UBO_DECLARATION_REFUSED";
    public const UboDeclarationValidated = "UBO_DECLARATION_VALIDATED";
    public const UboDeclarationIncomplete = "UBO_DECLARATION_INCOMPLETE";
    public const UserKycRegular = "USER_KYC_REGULAR";
    public const UserKycLight = "USER_KYC_LIGHT";
    public const UserInflowsBlocked = "USER_INFLOWS_BLOCKED";
    public const UserInflowsUnblocked = "USER_INFLOWS_UNBLOCKED";
    public const UserOutflowsBlocked = "USER_OUTFLOWS_BLOCKED";
    public const UserOutflowsUnblocked = "USER_OUTFLOWS_UNBLOCKED";
}
