<?php

use App\Enums\UserRoles;
use App\Models\Training;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    $training = Training::factory()->create(['user_id' => $this->user]);

    actingAs($this->user);

    Livewire::test('pages::trainings.edit', ['training' => $training])
        ->assertStatus(200);
});

it('admin can update a training', function () {
    $training = Training::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::trainings.edit', ['training' => $training])
        ->set('form.title', 'Nouveau Titre')
        ->call('save')
        ->assertHasNoErrors();

    expect($training->fresh()->title)->toBe('Nouveau Titre');
});

it('admin can delete a training', function () {
    $training = Training::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::trainings.edit', ['training' => $training])
        ->call('delete')
        ->assertRedirect(route('public.trainings.index', ['locale' => app()->getLocale()]));

    expect(Training::find($training->id))->toBeNull()
        ->and(Training::withTrashed()->find($training->id))->not->toBeNull();
});
