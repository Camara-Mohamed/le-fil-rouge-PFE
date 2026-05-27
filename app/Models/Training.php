<?php

namespace App\Models;

use App\Enums\Provinces;
use App\Enums\RegisterStatus;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'description',
    'banner',
    'start_date',
    'end_date',
    'type',
    'price',
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
class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'roles' => 'array',
            'status' => TrainingStatus::class,
            'province' => Provinces::class,
            'type' => TrainingTypes::class,
        ];
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

    public function isConfirmed(): bool
    {
        return $this->status === TrainingStatus::CONFIRMED;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function registers(): HasMany
    {
        return $this->hasMany(TrainingRegister::class);
    }

    public function pendingRegisters(): HasMany
    {
        return $this->hasMany(TrainingRegister::class)
            ->where('status', RegisterStatus::PENDING);
    }

    public function acceptedRegisters(): HasMany
    {
        return $this->hasMany(TrainingRegister::class)
            ->where('status', RegisterStatus::ACCEPTED);
    }

    public function refusedRegisters(): HasMany
    {
        return $this->hasMany(TrainingRegister::class)
            ->where('status', RegisterStatus::REFUSED);
    }

    public function roles(User $user): bool
    {
        return in_array($user->role->value, $this->roles);
    }

    public function getFormattedPrice(): string
    {
        if ($this->price === null || $this->price == 0) {
            return __('general.free');
        }

        return number_format($this->price, 2, ',', ' ').' €';
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
