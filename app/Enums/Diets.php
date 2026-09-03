<?php

namespace App\Enums;

enum Diets: string
{
    case NORMAL = 'normal';
    case VEGETARIAN = 'vegetarian';
    case VEGAN = 'vegan';
    case HALAL = 'halal';
    case KOSHER = 'kosher';
    case OTHER = 'other';

    public function label(): string
    {
        return __("enums/diets.{$this->value}");
    }
}
