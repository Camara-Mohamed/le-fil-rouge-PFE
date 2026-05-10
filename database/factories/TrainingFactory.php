<?php

namespace Database\Factories;

use App\Enums\Provinces;
use App\Enums\TrainingStatus;
use App\Enums\TrainingTypes;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

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
            TrainingTypes::RESIDENTIAL,
            TrainingTypes::NON_RESIDENTIAL,
        ];

        $statuses = [
            TrainingStatus::DRAFT,
            TrainingStatus::PENDING,
            TrainingStatus::PUBLISHED,
            TrainingStatus::REFUSED,
        ];

        $roles = [
            'animateur_1',
            'animateur_2',
            'brevete',
            'coordinateur',
            'formateur',
            'admin',
        ];

        return [
            'title' => fake()->sentence(3),
            'description' => fake()->text(),
            'banner' => null,
            'start_date' => fake()->dateTimeBetween('+2 days', '+1 week'),
            'end_date' => fake()->dateTimeBetween('+4 days', '+1 week'),
            'type' => fake()->randomElement($types),
            'price' => fake()->numberBetween(20, 120),
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
