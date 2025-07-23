<?php

namespace MangoPay;

use MangoPay\Libraries\EntityBase;

class PayByBankSupportedBank extends EntityBase
{
    /**
     * @var SupportedBank
     */
    public $SupportedBanks;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();
        $subObjects['SupportedBanks'] = '\MangoPay\SupportedBank';

        return $subObjects;
    }
}
