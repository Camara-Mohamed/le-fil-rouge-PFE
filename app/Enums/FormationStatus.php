<?php

namespace App\Enums;

enum FormationStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REFUSED = 'refused';
}
