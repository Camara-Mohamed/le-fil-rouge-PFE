<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'sujet' => $this->faker->word(),
            'message' => $this->faker->word(),
            'read_at'   => fake()->optional(0.4)->dateTimeBetween('-30 days', 'now'),
        ];
    }
}
