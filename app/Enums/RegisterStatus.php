<?php

namespace App\Enums;

enum RegisterStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';

    public function label(): string
    {
        return __("enums.register_status.{$this->value}");
    }
}
