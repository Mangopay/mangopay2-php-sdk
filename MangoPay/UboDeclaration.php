<?php

namespace MangoPay;

/**
 * UBO Declaration entity.
 */
class UboDeclaration extends Libraries\EntityBase
{
    /**
     * Owner's user ID.
     * Non-null, cannot be updated after creating declaration.
     * @var string
     */
    public $UserId;

    /**
     * Declaration status.
     * @var string
     * @see \MangoPay\UboDeclarationStatus
     */
    public $Status;

    /**
     * List of reasons why the declaration was refused.
     * @var string[]
     * @see \MangoPay\UboDeclarationRefusedReasonType
     */
    public $RefusedReasonTypes;

    /**
     * Explanation of why the declaration was refused.
     * @var string
     */
    public $RefusedReasonMessage;

    /**
     * Listed representations of natural users declared as UBOs.
     * When transmitting a UBO declaration (POST / PUT), must be an array of
     * IDs (string) of the users to be declared as UBOs.
     * In a received UBO declaration (GET), will be an array of representations
     * of the natural users declared as UBOs (\MangoPay\DeclaredUbo).
     * @var array
     */
    public $DeclaredUBOs;

    public function GetReadOnlyProperties()
    {
        $readOnly = parent::GetReadOnlyProperties();

        array_push($readOnly, "RefusedReasonTypes");
        array_push($readOnly, "RefusedReasonMessage");

        return $readOnly;
    }


}