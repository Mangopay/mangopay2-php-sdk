<?php
namespace MangoPay;

/**
 * Class represents template URL options
 */
class PayInTemplateURLOptions extends Libraries\Dto
{
    /**
     * PAYLINE options - Will be deprecated on March 31th (Sandbox) and April 30th (production)
     *
     * @var string
     */
    public $PAYLINE;
    
    /**
     * PAYLINEV2 options - to be used instead of PAYLINE options
     *
     * @var string
     */
    public $PAYLINEV2;
    
}
