<?php

namespace App\Models;

use App\Enums\RegisterStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(
    'notes',
    'status',
    'camp_id',
    'user_id'
)]
class CampRegister extends Model
{
    protected $fillable = [
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => RegisterStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    public function isPending(): bool
    {
        return $this->status === RegisterStatus::PENDING;
    }

    public function isAccepted(): bool
    {
        return $this->status === RegisterStatus::ACCEPTED;
    }

    public function isRefused(): bool
    {
        return $this->status === RegisterStatus::REFUSED;
    }
}
