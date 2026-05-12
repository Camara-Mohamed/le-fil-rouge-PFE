<?php

use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::enrollments')
        ->assertStatus(200);
});
