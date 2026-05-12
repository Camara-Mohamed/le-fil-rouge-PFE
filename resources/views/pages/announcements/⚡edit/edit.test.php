<?php

use App\Enums\UserRoles;
use App\Models\Announcement;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
    $this->announcement = Announcement::factory()->create();
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::announcements.edit', ['announcement' => $this->announcement])
        ->assertStatus(200);
});
