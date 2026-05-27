<?php

namespace App\Enums;

enum VolunteerRequestStatus: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return __("enums/volunteer_request_status.{$this->value}");
    }
}
