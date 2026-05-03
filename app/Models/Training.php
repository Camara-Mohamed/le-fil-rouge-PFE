<?php

namespace App\Models;

use App\Enums\FormationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'title',
    'description',
    'banner',
    'start_date',
    'end_date',
    'price',
    'participants',
    'details',
    'contraints',
    'address',
    'number',
    'city',
    'province',
    'postal_code',
    'galeries',
    'user_id',
])]
class Training extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'galeries' => 'array',
        ];
    }

    public function isDraft(): bool
    {
        return $this->status === FormationStatus::DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->status === FormationStatus::PUBLISHED;
    }

    public function isPending(): bool
    {
        return $this->status === FormationStatus::PENDING;
    }

    public function isRefused(): bool
    {
        return $this->status === FormationStatus::REFUSED;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
