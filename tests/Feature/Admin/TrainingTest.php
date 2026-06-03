<?php

use App\Enums\UserRoles;
use App\Models\Training;
use App\Models\User;

use function Pest\Laravel\actingAs;

it('admin can access trainings index', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('public.trainings.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('formateur can access trainings index', function () {
    $user = User::factory()->create(['role' => UserRoles::FORMATEUR]);

    actingAs($user)
        ->get(route('public.trainings.index', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access training create page', function () {
    $user = User::factory()->create(['role' => UserRoles::ADMIN]);

    actingAs($user)
        ->get(route('admin.trainings.create', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('formateur can access training create page', function () {
    $user = User::factory()->create(['role' => UserRoles::FORMATEUR]);

    actingAs($user)
        ->get(route('admin.trainings.create', ['locale' => 'fr']))
        ->assertStatus(200);
});

it('admin can access training edit page', function () {
    $user     = User::factory()->create(['role' => UserRoles::ADMIN]);
    $training = Training::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('admin.trainings.edit', ['locale' => 'fr', 'training' => $training]))
        ->assertStatus(200);
});

it('formateur can edit his own training', function () {
    $user     = User::factory()->create(['role' => UserRoles::FORMATEUR]);
    $training = Training::factory()->create(['user_id' => $user->id]);

    actingAs($user)
        ->get(route('admin.trainings.edit', ['locale' => 'fr', 'training' => $training]))
        ->assertStatus(200);
});

it('formateur cannot edit another formateur training', function () {
    $user     = User::factory()->create(['role' => UserRoles::FORMATEUR]);
    $training_creator    = User::factory()->create(['role' => UserRoles::FORMATEUR]);
    $training = Training::factory()->create(['user_id' => $training_creator->id]);

    actingAs($user)
        ->get(route('admin.trainings.edit', ['locale' => 'fr', 'training' => $training]))
        ->assertStatus(403);
});
