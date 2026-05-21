<?php

namespace App\Enums;

enum CampsTypes: string
{
    case STAGE = 'stage';
    case SEJOUR = 'sejour';

    public function label(): string
    {
        return __("enums.camps_types.{$this->value}");
    }
}
