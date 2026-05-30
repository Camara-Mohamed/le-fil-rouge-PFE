<?php

namespace App\Models;

use App\Enums\VolunteerRequestStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'phone',
    'message',
    'status',
    'read_at',
])]
class VolunteerRequest extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => VolunteerRequestStatus::class,
            'read_at' => 'datetime',
        ];
    }

    public function isPending(): bool
    {
        return $this->status === VolunteerRequestStatus::PENDING;
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
