<?php

namespace App\Enums;

enum Provider: string
{
    case Google = 'google';
    case Apple = 'apple';

    public function label(): string
    {
        return __("enums.provider.{$this->value}");
    }
}