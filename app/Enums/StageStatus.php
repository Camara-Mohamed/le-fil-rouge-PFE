<?php

namespace App\Enums;

enum StageStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REFUSED = 'refused';
}
