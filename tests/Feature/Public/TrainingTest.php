<?php

use App\Enums\TrainingStatus;
use App\Models\Training;

use function Pest\Laravel\get;

it('guest can see published trainings', function () {
    $training = Training::factory()->create(['status' => TrainingStatus::PUBLISHED]);

    get(route('public.trainings.index', ['locale' => 'fr']))
        ->assertSee($training->title);
});

it('guest cannot see pending trainings', function () {
    $training = Training::factory()->create(['status' => TrainingStatus::PENDING]);

    get(route('public.trainings.index', ['locale' => 'fr']))
        ->assertDontSee($training->title);
});

it('guest cannot see refused trainings', function () {
    $training = Training::factory()->create(['status' => TrainingStatus::REFUSED]);

    get(route('public.trainings.index', ['locale' => 'fr']))
        ->assertDontSee($training->title);
});

it('guest can access a published training show page', function () {
    $training = Training::factory()->create(['status' => TrainingStatus::PUBLISHED]);

    get(route('public.trainings.show', ['locale' => 'fr', 'training' => $training]))
        ->assertStatus(200)
        ->assertSee($training->title);
});

it('guest cannot access a pending training show page', function () {
    $training = Training::factory()->create(['status' => TrainingStatus::PENDING]);

    get(route('public.trainings.show', ['locale' => 'fr', 'training' => $training]))
        ->assertStatus(403);
});
