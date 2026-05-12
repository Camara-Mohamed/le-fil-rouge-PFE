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

it('admin can see a member', function () {
    $admin  = User::factory()->create(['role' => UserRoles::ADMIN]);
    $member = User::factory()->create(['first_name' => 'Dylan', 'last_name' => 'Piquin']);

    actingAs($admin)
        ->get(route('admin.members.index', ['locale' => app()->getLocale()]))
        ->assertSee($member->first_name ,'Dylan')
        ->assertSee($member->last_name ,'Piquin');
});
