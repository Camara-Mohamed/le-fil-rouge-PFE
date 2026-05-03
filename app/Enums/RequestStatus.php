<?php

namespace App\Enums;

enum RequestStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REFUSED = 'refused';
}
