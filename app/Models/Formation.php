<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title', 'description', 'banner', 'start_date', 'end_date', 'price', 'participants', 'details', 'contraints',
    'address', 'number', 'city', 'province', 'postal_code', 'galeries',
])]
class Formation extends Model
{
    use HasFactory, SoftDeletes;
}
