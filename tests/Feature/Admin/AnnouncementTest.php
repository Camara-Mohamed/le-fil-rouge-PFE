<?php

use App\Enums\UserRoles;
use App\Models\Announcement;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('admin can access announcements index', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('public.announcements.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access announcement create page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.announcements.create', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access announcement edit page', function () {
    $user         = User::factory()->create(['role' => UserRoles::ADMIN]);
    $announcement = Announcement::factory()->create();

    actingAs($user)
        ->get(route('admin.announcements.edit', ['locale' => 'fr', 'announcement' => $announcement]))
        ->assertStatus(200);
});
