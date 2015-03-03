<?php
namespace MangoPay\Enums;

/**
 * KYC document statuses
 */
class KycDocumentStatus{
    const Created = 'CREATED';
    const ValidationAsked = 'VALIDATION_ASKED';
    const Validated = 'VALIDATED';
    const Refused = 'REFUSED';
}
