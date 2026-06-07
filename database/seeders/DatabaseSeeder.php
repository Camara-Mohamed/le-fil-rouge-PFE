<?php

namespace Database\Seeders;

use App\Enums\Diets;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Training;
use App\Models\User;
use App\Models\VolunteerRequest;
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
        /* User::factory()->create([
            'first_name' => 'Mohamed',
            'last_name' => 'Camara',
            'email' => 'mohamed.camara@lefilrouge.com',
            'role' => UserRoles::ADMIN,
            'status' => UserStatus::COMPLETE,
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
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Hugo',
            'last_name' => 'Formateur',
            'email' => 'hugo.formateur@lefilrouge.com',
            'role' => UserRoles::FORMATEUR,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Paul',
            'last_name' => 'Coordinateur',
            'email' => 'paul.coordinateur@lefilrouge.com',
            'role' => UserRoles::COORDINATEUR,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Tiffany',
            'last_name' => 'Brevete',
            'email' => 'tiffany.brevete@lefilrouge.com',
            'role' => UserRoles::BREVETE,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Luc',
            'last_name' => 'Animateur_2e',
            'email' => 'paul.animateur2e@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_2,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Léa',
            'last_name' => 'Animateur_1re',
            'email' => 'lea.animateur1re@lefilrouge.com',
            'role' => UserRoles::ANIMATEUR_1,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]);

        User::factory()->create([
            'first_name' => 'Sam',
            'last_name' => 'Arrivant',
            'email' => 'sam.arrivant@lefilrouge.com',
            'role' => UserRoles::ARRIVANT,
            'status' => UserStatus::COMPLETE,
            'password' => Hash::make('change_this'),
        ]); */

        // Camp::factory()->count(12)->create();

        // Training::factory()->count(12)->create();

        // Announcement::factory()->count(20)->create();

        // Comment::factory()->count(20)->create();

        // ContactMessage::factory()->count(10)->create();

        // VolunteerRequest::factory()->count(6)->create();
    }
}
