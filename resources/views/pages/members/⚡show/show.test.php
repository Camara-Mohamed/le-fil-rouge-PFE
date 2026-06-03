<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    $member = User::factory()->create();

    actingAs($this->user);

    Livewire::test('pages::members.show', ['member' => $member])
        ->assertStatus(200);
});

it('admin can delete a member', function () {
    $member = User::factory()->create();

    actingAs($this->user);

    Livewire::test('pages::members.show', ['member' => $member])
        ->call('delete')
        ->assertRedirect(route('admin.members.index', ['locale' => app()->getLocale()]));

    expect($member->fresh()->status)->toBe(UserStatus::ARCHIVED);
});
