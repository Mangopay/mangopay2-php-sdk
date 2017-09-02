<?php

namespace MangoPay;

/**
 * Holds enumeration of possible UBO declaration status values.
 */
class UboDeclarationStatus
{
    /**
     * When the UBO declaration was created
     */
    const Created = 'CREATED';

    /**
     * When validation has been requested for the UBO declaration
     */
    const ValidationAsked = 'VALIDATION_ASKED';

    /**
     * When the UBO declaration was validated
     */
    const Validated = 'VALIDATED';

    /**
     * When the UBO declaration was refused
     */
    const Refused = 'REFUSED';
}