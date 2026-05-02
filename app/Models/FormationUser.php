<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormationUser extends Model
{
    use SoftDeletes;

    protected $table = 'formation_user';
}
