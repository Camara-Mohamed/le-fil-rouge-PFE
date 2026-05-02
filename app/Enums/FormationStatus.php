<?php

namespace App\Enums;

enum FormationStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Refused = 'refused';
}
