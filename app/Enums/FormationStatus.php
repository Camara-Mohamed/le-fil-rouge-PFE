<?php

namespace App\Enums;

enum FormationStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Refused = 'refused';
}
