<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'password',
    'role',
    'status',
    'phone',
    'birth_date',
    'address',
    'number',
    'city',
    'province',
    'postal_code',
    'diet',
    'allergies',
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
            'status' => UserStatus::class,
            'province' => Provinces::class,
            'diet' => Diets::class,
            'role' => UserRoles::class,
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRoles::ADMIN;
    }

    public function isFormateur(): bool
    {
        return $this->role === UserRoles::FORMATEUR;
    }

    public function isCoordinateur(): bool
    {
        return $this->role === UserRoles::COORDINATEUR;
    }

    public function isAnimateur1(): bool
    {
        return $this->role === UserRoles::ANIMATEUR_1;
    }

    public function isAnimateur2(): bool
    {
        return $this->role === UserRoles::ANIMATEUR_2;
    }

    public function isBrevete(): bool
    {
        return $this->role === UserRoles::BREVETE;
    }

    public function isArrivant(): bool
    {
        return $this->role === UserRoles::ARRIVANT;
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function trainings(): HasMany
    {
        return $this->hasMany(Training::class);
    }

    public function camps(): HasMany
    {
        return $this->hasMany(Camp::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function trainingRegisters(): HasMany
    {
        return $this->hasMany(TrainingRegister::class);
    }

    public function campRegisters(): HasMany
    {
        return $this->hasMany(CampRegister::class);
    }

    public function getAge(): int
    {
        return Carbon::parse($this->birth_date)->age;
    }

    public function isIncomplet(): bool
    {
        return $this->status === UserStatus::INCOMPLETE;
    }

    public function isEnAttente(): bool
    {
        return $this->status === UserStatus::PENDING;
    }

    public function isComplet(): bool
    {
        return $this->status === UserStatus::COMPLETE;
    }
}
