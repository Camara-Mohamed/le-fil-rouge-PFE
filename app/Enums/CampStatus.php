<?php

namespace App\Enums;

enum CampStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REFUSED = 'refused';
    case CONFIRMED = 'confirmed';

    public function label(): string
    {
        return __("enums.camp_status.{$this->value}");
    }
}
