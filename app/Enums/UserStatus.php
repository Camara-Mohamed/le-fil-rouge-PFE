<?php

namespace App\Enums;

enum UserStatus: string
{
    case INCOMPLETE = 'incomplet';
    case PENDING = 'pending';
    case COMPLETE = 'complet';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return __("enums/user_status.{$this->value}");
    }
}
