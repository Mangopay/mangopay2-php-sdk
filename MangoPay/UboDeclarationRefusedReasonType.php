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
    public const MissingUbo = 'MISSING_UBO';

    /**
     * When at least one natural user should not be declared as UBO
     */
    public const DeclarationDoNotMatchUboInformation = 'DECLARATION_DO_NOT_MATCH_UBO_INFORMATION';
}
