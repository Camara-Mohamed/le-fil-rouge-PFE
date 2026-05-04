<?php

namespace App\Models;

use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'phone',
    'message',
    'status',
])]
class VolunteerRequest extends Model
{
    protected function casts(): array
    {
        return [
            'status' => RegisterStatus::class,
        ];
    }

    public function isPending(): bool
    {
        return $this->status === RegisterStatus::PENDING;
    }
}
