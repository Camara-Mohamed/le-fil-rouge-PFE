<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\Camp;
use App\Models\Comment;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->word(),
            'user_id' => User::factory(),
            'training_id' => Training::factory(),
            'camp_id' => Camp::factory(),
            'announcement_id' => Announcement::factory(),
            'is_admin' => fake()->boolean(),
        ];
    }
}
