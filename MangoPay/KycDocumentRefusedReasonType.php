<?php

namespace MangoPay;

/**
 * Kyc Refused Reason Type
 */
class KycDocumentRefusedReasonType
{
    const DocumentUnreadable = 'DOCUMENT_UNREADABLE';
    const DocumentNotAccepted = 'DOCUMENT_NOT_ACCEPTED';
    const DocumentHasExpired = 'DOCUMENT_HAS_EXPIRED';
    const DocumentIncomplete = 'DOCUMENT_INCOMPLETE';
    const DocumentMissing = 'DOCUMENT_MISSING';
    const DocumentDoesNotMatchUserData = 'DOCUMENT_DO_NOT_MATCH_USER_DATA';
    const DocumentDoesNotMatchAccountData = 'DOCUMENT_DO_NOT_MATCH_ACCOUNT_DATA';
    const SpecificCase = 'SPECIFIC_CASE';
    const DocumentFalsified = 'DOCUMENT_FALSIFIED';
    const UnderagePerson = 'UNDERAGE_PERSON';
    const TriggerPEPS = 'TRIGGER_PEPS';
    const TriggerSanactionLists = 'TRIGGER_SANACTION_LISTS';
    const TriggerInterpol = 'TRIGGER_INTERPOL';
}
