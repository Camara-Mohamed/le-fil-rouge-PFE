<?php

namespace App\Enums;

enum Diets: string
{
    case NORMAL = 'normal';
    case VEGETARIAN = 'vegetarian';
    case VEGAN = 'vegan';
    case HALAL = 'halal';
    case KOSHER = 'kosher';
    case GLUTEN_FREE = 'gluten_free';
    case LACTOSE_FREE = 'lactose_free';
    case OTHER = 'other';

    public function label(): string
    {
        return __("enums/diets.{$this->value}");
    }
}
