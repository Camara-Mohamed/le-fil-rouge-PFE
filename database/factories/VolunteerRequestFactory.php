<?php

namespace Database\Factories;

use App\Enums\VolunteerRequestStatus;
use App\Models\VolunteerRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerRequestFactory extends Factory
{
    protected $model = VolunteerRequest::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'message' => fake()->word(),
            'status' => fake()->randomElement(VolunteerRequestStatus::cases()),
            'read_at' => fake()->optional(0.4)->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
