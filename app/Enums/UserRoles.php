<?php

namespace App\Enums;

enum UserRoles: string
{
    case ARRIVANT = 'arrivant';
    case ANIMATEUR_1 = 'animateur_1';
    case ANIMATEUR_2 = 'animateur_2';
    case BREVETE = 'brevete';
    case COORDINATEUR = 'coordinateur';
    case FORMATEUR = 'formateur';
    case ADMIN = 'admin';

    public function label(): string
    {
        return __("enums/user_roles.{$this->value}");
    }

    public static function registrable(): array
    {
        return [self::ANIMATEUR_1, self::ANIMATEUR_2, self::BREVETE, self::COORDINATEUR, self::FORMATEUR];
    }
}
