<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Mohamed',
            'last_name' => 'Camara',
            'email' => 'mohamed.camara@lefilrouge.com',
            'role' => UserRole::ADMIN,
            'password' => Hash::make('change_this'),
            'birth_date' => fake()->dateTimeBetween('-28 years', '-18 years'),
        ]);

        User::factory()->create([
            'first_name' => 'Stéphanie',
            'last_name' => 'Admin',
            'email' => 'stephanie.admin@lefilrouge.com',
            'role' => UserRole::ADMIN,
            'password' => Hash::make('change_this'),
            'birth_date' => fake()->dateTimeBetween('-60 years', '-18 years'),
        ]);
    }
}
