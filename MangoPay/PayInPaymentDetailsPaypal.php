<?php
namespace MangoPay;
/**
 * Class represents PayPal type for mean of payment in PayIn entity
 */
class PayInPaymentDetailsPaypal extends Libraries\Dto implements PayInPaymentDetails
{
    /**
     * Address used instead of the user's PayPal account address.
     * @var ShippingAddress
     */
    public $ShippingAddress;

    public function GetSubObjects()
    {
        $subObjects = parent::GetSubObjects();

        $subObjects['ShippingAddress'] = '\Mangopay\ShippingAddress';

        return $subObjects;
    }
}