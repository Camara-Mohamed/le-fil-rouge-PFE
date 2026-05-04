<?php

namespace App\Enums;

enum TrainingStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case PUBLISHED = 'published';
    case REFUSED = 'refused';
}
