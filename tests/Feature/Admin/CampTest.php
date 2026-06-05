<?php

use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('admin can access camps index', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('public.camps.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('coordinateur can access camps index', function () {
    $user = User::factory()->create(['role' => UserRoles::COORDINATEUR]);

    actingAs($user)
        ->get(route('public.camps.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access camp create page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.camps.create', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('coordinateur can access camp create page', function () {
    $user = User::factory()->create(['role' => UserRoles::COORDINATEUR]);

    actingAs($user)
        ->get(route('admin.camps.create', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access camp edit page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);
    $camp = Camp::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('admin.camps.edit', ['locale' => 'fr', 'camp' => $camp]))
        ->assertStatus(200);
});

it('coordinateur can edit his own camp', function () {
    $user = User::factory()->create(['role' => UserRoles::COORDINATEUR]);
    $camp = Camp::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('admin.camps.edit', ['locale' => 'fr', 'camp' => $camp]))
        ->assertStatus(200);
});

it('coordinateur cannot edit another coordinateur camp', function () {
    $user = User::factory()->create(['role' => UserRoles::COORDINATEUR]);
    $camp_creator = User::factory()->create(['role' => UserRoles::COORDINATEUR]);
    $camp = Camp::factory()->create(['user_id' => $camp_creator->id]);

    actingAs($user)
        ->get(route('admin.camps.edit', ['locale' => 'fr', 'camp' => $camp]))
        ->assertStatus(403);
});
