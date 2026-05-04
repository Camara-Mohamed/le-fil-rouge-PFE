<?php

namespace App\Models;

use App\Enums\TrainingStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title',
    'description',
    'banner',
    'start_date',
    'end_date',
    'type',
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
class Camp extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->status === TrainingStatus::DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->status === TrainingStatus::PUBLISHED;
    }

    public function isPending(): bool
    {
        return $this->status === TrainingStatus::PENDING;
    }

    public function isRefused(): bool
    {
        return $this->status === TrainingStatus::REFUSED;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
