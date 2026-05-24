<?php

namespace App\Models;

use App\Enums\CampStatus;
use App\Enums\CampTypes;
use App\Enums\Provinces;
use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    'constraints',
    'address',
    'number',
    'city',
    'province',
    'postal_code',
    'roles',
    'status',
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
            'roles' => 'array',
            'status' => CampStatus::class,
            'province' => Provinces::class,
            'type' => CampTypes::class,
        ];
    }

    public function isPublished(): bool
    {
        return $this->status === CampStatus::PUBLISHED;
    }

    public function isPending(): bool
    {
        return $this->status === CampStatus::PENDING;
    }

    public function isRefused(): bool
    {
        return $this->status === CampStatus::REFUSED;
    }

    public function isConfirmed(): bool
    {
        return $this->status === CampStatus::CONFIRMED;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registers(): HasMany
    {
        return $this->hasMany(CampRegister::class);
    }

    public function pendingRegisters(): HasMany
    {
        return $this->hasMany(CampRegister::class)
            ->where('status', RegisterStatus::PENDING);
    }

    public function acceptedRegisters(): HasMany
    {
        return $this->hasMany(CampRegister::class)
            ->where('status', RegisterStatus::ACCEPTED);
    }

    public function refusedRegisters(): HasMany
    {
        return $this->hasMany(CampRegister::class)
            ->where('status', RegisterStatus::REFUSED);
    }

    public function roles(User $user): bool
    {
        return in_array($user->role->value, $this->roles);
    }

    public function galeries(): HasMany
    {
        return $this->hasMany(Galerie::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
