<?php

use App\Enums\UserRoles;
use App\Models\Training;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    actingAs($this->admin);

    Livewire::test('pages::trainings.create')
        ->assertStatus(200);
});

it('admin can create a training', function () {
    actingAs($this->admin);

    Livewire::test('pages::trainings.create')
        ->set('form.title', 'Formation Animateur')
        ->set('form.description', 'Description de la formation')
        ->set('form.start_date', '2026-07-01T09:00')
        ->set('form.end_date', '2026-07-03T17:00')
        ->set('form.type', 'residential')
        ->set('form.status', 'pending')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(Training::where('title', 'Formation Animateur')->exists())->toBeTrue();
});

it('formateur can create a training', function () {
    $formateur = User::factory()->create(['role' => UserRoles::FORMATEUR]);
    actingAs($formateur);

    Livewire::test('pages::trainings.create')
        ->set('form.title', 'Formation Animateur')
        ->set('form.description', 'Description')
        ->set('form.start_date', '2026-07-01T09:00')
        ->set('form.end_date', '2026-07-03T17:00')
        ->set('form.type', 'residential')
        ->set('form.status', 'pending')
        ->call('save')
        ->assertHasNoErrors();
});

it('validation fails without required fields', function () {
    actingAs($this->admin);

    Livewire::test('pages::trainings.create')
        ->call('save')
        ->assertHasErrors(['form.title', 'form.description']);
});
