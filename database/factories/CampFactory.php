<?php

namespace Database\Factories;

use App\Enums\CampStatus;
use App\Enums\CampsTypes;
use App\Enums\Provinces;
use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampFactory extends Factory
{
    protected $model = Camp::class;

    public function definition(): array
    {
        $provinces = [
            Provinces::ANVERS,
            Provinces::BRABANT_WALLON,
            Provinces::BRUXELLES,
            Provinces::FLANDRE_OCCIDENTALE,
            Provinces::FLANDRE_ORIENTALE,
            Provinces::HAINAUT,
            Provinces::LIEGE,
            Provinces::LIMBOURG,
            Provinces::LUXEMBOURG,
            Provinces::NAMUR,
            Provinces::BRABANT_FLAMAND,
        ];

        $types = [
            CampsTypes::STAGE,
            CampsTypes::SEJOUR,
        ];

        $statuses = [
            CampStatus::DRAFT,
            CampStatus::PENDING,
            CampStatus::PUBLISHED,
            CampStatus::REFUSED,
        ];

        $roles = [
            'animateur_1',
            'animateur_2',
            'brevete',
            'coordinateur',
            'formateur',
        ];

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->text(),
            'banner' => null,
            'start_date' => fake()->dateTimeBetween('+2 days', '+1 week'),
            'end_date' => fake()->dateTimeBetween('+4 days', '+1 week'),
            'type' => fake()->randomElement($types),
            'participants' => fake()->numberBetween(10, 40),
            'details' => fake()->paragraph(),
            'constraints' => fake()->paragraph(),
            'address' => fake()->streetAddress(),
            'number' => fake()->buildingNumber(),
            'city' => fake()->city(),
            'province' => fake()->randomElement($provinces),
            'postal_code' => fake()->postcode(),
            'user_id' => User::factory(),
            'roles' => json_encode($roles),
            'status' => fake()->randomElement($statuses),
            'galeries' => null,
        ];
    }
}
