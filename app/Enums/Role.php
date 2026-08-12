<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Customer = 'customer';

    public function label(): string
    {
        return __("enums.role.{$this->value}");
    }
}