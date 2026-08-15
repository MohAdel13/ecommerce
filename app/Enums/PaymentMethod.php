<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case COD = 'cash on delivery';
    case CreditCard = 'credit card';

    public function label(): string
    {
        return __("enums.payment_method.{$this->value}");
    }
}