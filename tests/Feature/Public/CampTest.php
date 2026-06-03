<?php

use App\Enums\CampStatus;
use App\Models\Camp;
use function Pest\Laravel\get;

it('guest can see published camps', function () {
    $camp = Camp::factory()->create(['status' => CampStatus::PUBLISHED]);

    get(route('public.camps.index', ['locale' => 'fr']))
        ->assertSee($camp->title);
});

it('guest cannot see pending camps', function () {
    $camp = Camp::factory()->create(['status' => CampStatus::PENDING]);

    get(route('public.camps.index', ['locale' => 'fr']))
        ->assertDontSee($camp->title);
});

it('guest cannot see refused camps', function () {
    $camp = Camp::factory()->create(['status' => CampStatus::REFUSED]);

    get(route('public.camps.index', ['locale' => 'fr']))
        ->assertDontSee($camp->title);
});

it('guest can access a published camp show page', function () {
    $camp = Camp::factory()->create(['status' => CampStatus::PUBLISHED]);

    get(route('public.camps.show', ['locale' => 'fr', 'camp' => $camp]))
        ->assertStatus(200)
        ->assertSee($camp->title);
});

it('guest cannot access a pending camp show page', function () {
    $camp = Camp::factory()->create(['status' => CampStatus::PENDING]);

    get(route('public.camps.show', ['locale' => 'fr', 'camp' => $camp]))
        ->assertStatus(403);
});
