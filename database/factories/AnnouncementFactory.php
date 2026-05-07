<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'description' => fake()->text(),
            'details' => fake()->paragraph(),
            'content' => fake()->paragraphs(4, true),
            'banner' => null,
            'user_id' => User::factory(),
            'published_at' => fake()->dateTime(),
        ];
    }
}
