<?php
namespace MangoPay;

/**
 * Class represents Web type for execution option in PayIn entity
 */
class PayInExecutionDetailsWeb extends Dto implements PayInExecutionDetails {

    /**
     * URL format expected.
     * @var string
     */
    public $TemplateURL;
    
    /**
     * @var bool
     */
    public $ShowRegisteredCard;
    
    /**
     * @var bool
     */
    public $RegisterCard;
    
    /**
     * @var string
     */
    public $Culture;
    
    /**
     * Mode3DSType { DEFAULT, FORCE }
     * @var string
     */
    public $Mode3DS;
}