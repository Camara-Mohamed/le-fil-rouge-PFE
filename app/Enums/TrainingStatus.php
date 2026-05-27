<?php

namespace App\Enums;

enum TrainingStatus: string
{
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REFUSED = 'refused';
    case CONFIRMED = 'confirmed';

    public function label(): string
    {
        return __("enums/training_status.{$this->value}");
    }
}
