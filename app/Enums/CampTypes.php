<?php

namespace App\Enums;

enum CampTypes: string
{
    case STAGE = 'stage';
    case SEJOUR = 'sejour';

    public function label(): string
    {
        return __("enums/camp_types.{$this->value}");
    }
}
