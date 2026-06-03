<?php

use App\Enums\UserRoles;
use App\Models\Camp;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    $camp = Camp::factory()->create(['user_id' => $this->user]);

    actingAs($this->user);

    Livewire::test('pages::camps.edit', ['camp' => $camp])
        ->assertStatus(200);
});

it('admin can update a camp', function () {
    $camp = Camp::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::camps.edit', ['camp' => $camp])
        ->set('form.title', 'Nouveau Titre')
        ->call('save')
        ->assertHasNoErrors();

    expect($camp->fresh()->title)->toBe('Nouveau Titre');
});

it('admin can delete a camp', function () {
    $camp = Camp::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::camps.edit', ['camp' => $camp])
        ->call('delete')
        ->assertRedirect(route('public.camps.index', ['locale' => app()->getLocale()]));

    expect(Camp::find($camp->id))->toBeNull()
        ->and(Camp::withTrashed()->find($camp->id))->not->toBeNull();
});
