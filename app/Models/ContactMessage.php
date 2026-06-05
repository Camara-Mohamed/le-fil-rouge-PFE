<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'full_name',
    'email',
    'sujet',
    'message',
    'read_at',
])]
class ContactMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }
}
