<?php

namespace MangoPay;

/**
 * Holds enumeration of possible statuses of a declared UBO.
 */
class DeclaredUboStatus
{
    /**
     * When declaration of a UBO was created
     */
    const Created = 'CREATED';

    /**
     * When declaration of a UBO was validated
     */
    const Validated = 'VALIDATED';

    /**
     * When declaration of a UBO was refused
     */
    const Refused = 'REFUSED';
}
