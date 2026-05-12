<?php

use App\Enums\UserRoles;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::members.index')
        ->assertStatus(200);
});

it('admin can delete a member', function () {
    $admin = User::factory()->create(['role' => UserRoles::ADMIN]);
    $member = User::factory()->create();

    actingAs($admin);

    Livewire::test('pages::members.show', ['member' => $member])
        ->call('delete')
        ->assertRedirect(route('admin.members.index', ['locale' => app()->getLocale()]));

    $this->assertNull(User::find($member->id));
});
