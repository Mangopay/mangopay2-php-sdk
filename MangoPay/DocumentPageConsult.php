<?php
namespace MangoPay;


/**
 * Holds document page viewing data.
 */
class DocumentPageConsult
{
    /**
     * URL where this document page can be viewed.
     * @var string
     */
    public $Url;

    /**
     * Time in millis when the page consult will expire.
     * @var Long
     */
    public $ExpirationDate;
}