<?php

use App\Enums\UserRoles;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('verifies if user can access admin dashboard page as a connected', function () {
    actingAs($this->user);

    $response = $this->get(route('admin.dashboard', ['locale' => app()->getLocale()]));

    $response->assertStatus(200);
});

it('verifies if user with admin role can access admin members', function () {
    $user = User::factory()->create([
        'role' => UserRoles::ADMIN,
    ]);

    actingAs($user);
    $response = $this->get(route('admin.members.index', ['locale' => app()->getLocale()]));

    $response->assertStatus(200);
});

it('verifies if user with brevete role can access admin members', function () {
    $user = User::factory()->create([
        'role' => UserRoles::BREVETE,
    ]);

    actingAs($user);
    $response = $this->get(route('admin.members.index', ['locale' => app()->getLocale()]));

    $response->assertStatus(403);
});

it('verifies if user with admin role can access his profile page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.profile', ['locale' => app()->getLocale()]))
        ->assertStatus(200);
});

it('verifies if user with formateur role can access his profile page', function () {
    $user = User::factory()->create(['role' => UserRoles::FORMATEUR]);

    actingAs($user)
        ->get(route('admin.profile', ['locale' => app()->getLocale()]))
        ->assertStatus(200);
});

it('verifies if user with coordinateur role can access his profile page', function () {
    $user = User::factory()->create(['role' => UserRoles::COORDINATEUR]);

    actingAs($user)
        ->get(route('admin.profile', ['locale' => app()->getLocale()]))
        ->assertStatus(200);
});

it('verifies if user with arrivant role can access his profile page', function () {
    $user = User::factory()->create(['role' => UserRoles::ARRIVANT]);

    actingAs($user)
        ->get(route('admin.profile', ['locale' => app()->getLocale()]))
        ->assertStatus(200);
});

it('admin can access messages page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.messages.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('non-admin cannot access messages page', function () {
    $user = User::factory()->create(['role' => UserRoles::BREVETE]);

    actingAs($user)
        ->get(route('admin.messages.index', ['locale' => 'fr']))
        ->assertStatus(403);
});

it('admin can access members index', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.members.index', ['locale' => 'fr']))
        ->assertStatus(200);
});
