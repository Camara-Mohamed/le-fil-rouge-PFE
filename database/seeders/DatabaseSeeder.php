<?php

namespace Database\Seeders;

use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\Training;
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
        User::factory()->count(8)->create();

        User::factory()->create([
            'first_name' => 'Mohamed',
            'last_name' => 'Camara',
            'email' => 'mohamed.camara@lefilrouge.com',
            'role' => UserRoles::ADMIN,
            'password' => Hash::make('change_this'),
            'birth_date' => fake()->dateTimeBetween('-28 years', '-18 years'),
            'phone' => '0123456789',
            'address' => 'Rue du Vallon',
            'number' => '1B',
            'city' => 'Liege',
            'province' => Provinces::LIEGE,
            'postal_code' => '4000',
            'diet' => Diets::NORMAL,
            'allergies' => null,
        ]);

        User::factory()->create([
            'first_name' => 'Stéphanie',
            'last_name' => 'Admin',
            'email' => 'stephanie.admin@lefilrouge.com',
            'role' => UserRoles::ADMIN,
            'password' => Hash::make('change_this'),
        ]);

        Camp::factory()->count(4)->create();
    }
}
