<?php

namespace App\Enums;

enum FormationStageStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Refused = 'refused';
}
