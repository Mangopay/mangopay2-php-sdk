<?php

namespace MangoPay;

/**
 * Holds enumeration of reasons why declaration of a user as UBO was refused
 */
class UboRefusedReasonType
{
    /**
     * When user should not be declared as UBO
     */
    const InvalidDeclaredUbo = 'INVALID_DECLARED_UBO';

    /**
     * When user declared as UBO was created with wrong
     * details (i.e. date of birth, country of residence)
     */
    const InvalidUboDetails = 'INVALID_UBO_DETAILS';
}