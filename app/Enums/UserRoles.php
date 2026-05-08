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
}
