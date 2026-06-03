<?php

use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    actingAs($this->admin);

    Livewire::test('pages::camps.create')
        ->assertStatus(200);
});

it('admin can create a camp', function () {
    actingAs($this->admin);

    Livewire::test('pages::camps.create')
        ->set('form.title', 'Stage AV Chênée')
        ->set('form.description', 'Description du stage')
        ->set('form.start_date', '2026-07-10T09:00')
        ->set('form.end_date', '2026-07-15T17:00')
        ->set('form.type', 'stage')
        ->set('form.status', 'pending')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(Camp::where('title', 'Stage AV Chênée')->exists())->toBeTrue();
});

it('coordinateur can create a camp', function () {
    $coordinateur = User::factory()->create(['role' => UserRoles::COORDINATEUR]);
    actingAs($coordinateur);

    Livewire::test('pages::camps.create')
        ->set('form.title', 'AV Chênée')
        ->set('form.description', 'Description')
        ->set('form.start_date', '2026-07-10T09:00')
        ->set('form.end_date', '2026-07-15T17:00')
        ->set('form.type', 'stage')
        ->set('form.status', 'pending')
        ->call('save')
        ->assertHasNoErrors();
});

it('validation fails without required fields', function () {
    actingAs($this->admin);

    Livewire::test('pages::camps.create')
        ->call('save')
        ->assertHasErrors(['form.title', 'form.description']);
});
