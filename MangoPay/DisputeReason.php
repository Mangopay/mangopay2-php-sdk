<?php

namespace MangoPay;

/**
 * Class represents dispute's reason
 */
class DisputeReason extends Libraries\Dto
{
    
    /**
     * Dispute's reason type
     * @var \MangoPay\DisputeReasonType
     */
    public $DisputeReasonType;
    
    /**
     * Dispute's reason message
     * @var string
     */
    public $DisputeReasonMessage;
}
