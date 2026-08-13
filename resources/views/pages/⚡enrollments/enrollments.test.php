<?php

use App\Enums\UserRoles;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ARRIVANT]);
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::enrollments')
        ->assertStatus(200);
});
