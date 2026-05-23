<?php

use App\Enums\UserRoles;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders successfully', function () {
    $admin = User::factory()->create(['role' => UserRoles::ADMIN]);
    $member = User::factory()->create();

    actingAs($admin);

    Livewire::test('pages::members.edit', ['member' => $member])
        ->assertStatus(200);
});
