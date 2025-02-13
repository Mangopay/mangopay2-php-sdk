<?php

namespace MangoPay;

use MangoPay\Libraries\Dto;

class CheckData extends Dto
{
    /**
     * The type of the data point.
     *  For more details, <a href="https://mangopay-idv.mintlify.app/guides/users/verification/hosted?_gl=1*1unwn0t*_up*MQ..*_ga*ODg5MjI4ODQzLjE3Mzg5MjY2NjE.*_ga_VZLQHP6CFB*MTczODkyNjY2MC4xLjAuMTczODkyNjY2MC4wLjAuMA..#verified-data-returned">see the Verified data returned.</a>
     * @var string
     */
    public $Type;

    /**
     * The value of the data point.
     * @var string
     */
    public $Value;
}
