<?php
namespace MangoPay;

/**
 * Security & validation information
 */
class SecurityInfo extends Libraries\Dto
{

    /**
     * Result of the AVS verification
     * @var string (see \MangoPay\AVSResult)
     */
    public $AVSResult;
}