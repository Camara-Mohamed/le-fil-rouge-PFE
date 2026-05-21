<?php

namespace App\Enums;

enum Provinces: string
{
    case ANVERS = 'anvers';
    case BRABANT_WALLON = 'brabant_wallon';
    case BRUXELLES = 'bruxelles';
    case FLANDRE_OCCIDENTALE = 'flandre_occidentale';
    case FLANDRE_ORIENTALE = 'flandre_orientale';
    case HAINAUT = 'hainaut';
    case LIEGE = 'liege';
    case LIMBOURG = 'limbourg';
    case LUXEMBOURG = 'luxembourg';
    case NAMUR = 'namur';
    case BRABANT_FLAMAND = 'brabant_flamand';

    public function label(): string
    {
        return __("enums.provinces.{$this->value}");
    }
}
