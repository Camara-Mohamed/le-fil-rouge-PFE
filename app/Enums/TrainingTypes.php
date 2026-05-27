<?php

namespace App\Enums;

enum TrainingTypes: string
{
    case RESIDENTIAL = 'residential';
    case NON_RESIDENTIAL = 'non_residential';

    public function label(): string
    {
        return __("enums/training_types.{$this->value}");
    }
}
