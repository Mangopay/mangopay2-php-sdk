<?php

namespace MangoPay;

/**
 * Holds document page viewing data.
 */
class DocumentPageConsult extends Libraries\Dto
{
    /**
     * URL where this document page can be viewed.
     * @var string
     */
    public $Url;

    /**
     * Time in millis when the page consult will expire.
     * @var int
     */
    public $ExpirationDate;
}
