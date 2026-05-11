<?php

namespace Database\Seeders;

use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
            'role' => UserRoles::ADMIN,
            'password' => Hash::make('change_this'),
            'birth_date' => fake()->dateTimeBetween('-28 years', '-18 years'),
            'phone' => fake()->phoneNumber,
            'address' => 'Rue du Vallon',
            'number' => fake()->buildingNumber(),
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

        User::factory()->create([
            'first_name' => 'Hugo',
            'last_name' => 'Formateur',
            'email' => 'hugo.formateur@lefilrouge.com',
            'role' => UserRoles::FORMATEUR,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Paul',
            'last_name' => 'Coordinateur',
            'email' => 'paul.coordinateur@lefilrouge.com',
            'role' => UserRoles::COORDINATEUR,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Sam',
            'last_name' => 'Arrivant',
            'email' => 'sam.arrivant@lefilrouge.com',
            'role' => UserRoles::ARRIVANT,
            'password' => Hash::make('change_this'),
        ]);

        Camp::factory()->count(12)->create();

        Training::factory()->count(12)->create();

        Announcement::factory()->count(6)->create();
    }
}
