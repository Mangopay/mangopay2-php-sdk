<?php

namespace MangoPay;

/**
 * User entity
 */
class EMoney extends Libraries\EntityBase
{
    /**
     * Owner object owner's UserId
     * @var string
     */
    public $UserId;

    /**
     * The amount of money that has been credited to this user
     * @var object
     */
    public $CreditedEMoney;

    /**
     * The amount of money that has been debited from the user
     * @var object
     */
    public $DebitedEMoney;

    /**
     * Get array with mapping which property is object and what type of object
     * @return array
     */
    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['CreditedEMoney'] = '\MangoPay\Money';
        $subObjects['DebitedEMoney'] = '\MangoPay\Money';

        return $subObjects;
    }
}
