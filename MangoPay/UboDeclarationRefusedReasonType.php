<?php

namespace MangoPay;

/**
 * Holds enumeration of possible reasons why a UBO declaration was refused.
 */
class UboDeclarationRefusedReasonType
{
    /**
     * When at least one natural user is missing on the declaration
     */
    const MissingUbo = 'MISSING_UBO';

    /**
     * When at least one natural user should not be declared as UBO
     */
    const InvalidDeclaredUbo = 'INVALID_DECLARED_UBO';

    /**
     * When at least one natural user declared as UBO has been created
     * with wrong details (i.e. date of birth, country of residence)
     */
    const InvalidUboDetails = 'INVALID_UBO_DETAILS';
}