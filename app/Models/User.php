<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'password',
    'role',
    'phone',
    'birth_date',
    'address',
    'number',
    'city',
    'province',
    'postal_code',
    'avatar_path',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isFormateur(): bool
    {
        return $this->role === UserRole::FORMATEUR;
    }

    public function isCoordinateur(): bool
    {
        return $this->role === UserRole::COORDINATEUR;
    }

    public function isAnimateur1(): bool
    {
        return $this->role === UserRole::ANIMATEUR_1;
    }

    public function isAnimateur2(): bool
    {
        return $this->role === UserRole::ANIMATEUR_2;
    }

    public function isBrevete(): bool
    {
        return $this->role === UserRole::BREVETE;
    }

    public function isArrivant(): bool
    {
        return $this->role === UserRole::ARRIVANT;
    }

    public function userDocuments(): HasMany
    {
        return $this->hasMany(UserDocument::class);
    }

    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Stage::class);
    }

    public function newEvents(): HasMany
    {
        return $this->hasMany(NewEvent::class);
    }
}
