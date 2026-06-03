<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::profile')
        ->assertStatus(200);
});

it('user can update his profile', function () {
    actingAs($this->user);

    Livewire::test('pages::profile')
        ->set('info.first_name', 'Mohamed')
        ->set('info.last_name', 'Camara')
        ->set('info.phone', '+32 470 00 00 00')
        ->call('saveInfo')
        ->assertHasNoErrors();

    expect($this->user->fresh()->first_name)->toBe('Mohamed');
});
