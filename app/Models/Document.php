<?php

namespace App\Models;

use App\Enums\DocumentTypes;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'type',
    'name',
    'path',
    'user_id',
])]
class Document extends Model
{
    use SoftDeletes;

    public function casts(): array
    {
        return [
            'type' => DocumentTypes::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
