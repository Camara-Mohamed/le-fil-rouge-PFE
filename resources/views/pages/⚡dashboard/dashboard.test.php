<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('can you access to dashboard like if you are connected user', function () {
    actingAs($this->user);

    Livewire::test('pages::dashboard')
        ->assertStatus(200);
});
