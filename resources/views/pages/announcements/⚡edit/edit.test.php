<?php

use App\Enums\UserRoles;
use App\Models\Announcement;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    $announcement = Announcement::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::announcements.edit', ['announcement' => $announcement])
        ->assertStatus(200);
});

it('admin can update an announcement', function () {
    $announcement = Announcement::factory()->create(['user_id' => $this->user]);

    actingAs($this->user);

    Livewire::test('pages::announcements.edit', ['announcement' => $announcement])
        ->set('form.title', 'Titre Modifié')
        ->call('save')
        ->assertHasNoErrors();

    expect($announcement->fresh()->title)->toBe('Titre Modifié');
});

it('admin can delete an announcement', function () {
    $announcement = Announcement::factory()->create(['user_id' => $this->user]);
    actingAs($this->user);

    Livewire::test('pages::announcements.edit', ['announcement' => $announcement])
        ->call('delete')
        ->assertRedirect(route('public.announcements.index', ['locale' => app()->getLocale()]));

    expect(Announcement::find($announcement->id))->toBeNull();
});
