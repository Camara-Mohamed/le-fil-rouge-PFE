<?php

use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\User;
use App\Notifications\AnnouncementNotification;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create(['role' => UserRoles::ADMIN]);
});

it('renders successfully', function () {
    actingAs($this->user);

    Livewire::test('pages::announcements.create')
        ->assertStatus(200);
});

it('admin can create an announcement', function () {
    Notification::fake();

    actingAs($this->user);

    Livewire::test('pages::announcements.create')
        ->set('form.title', 'Nouvelle Actualité')
        ->set('form.description', 'Description')
        ->set('form.content', 'Content')
        ->call('save');

    $this->assertDatabaseHas('announcements', ['title' => 'Nouvelle Actualité']);
});

it('sends notification to users when announcement is created', function () {
    Notification::fake();

    $members = User::factory(3)->create(['status' => UserStatus::COMPLETE]);

    actingAs($this->user);

    Livewire::test('pages::announcements.create')
        ->set('form.title', 'Titre')
        ->set('form.description', 'Description')
        ->set('form.content', 'Contenu')
        ->call('save');

    Notification::assertSentTo($members, AnnouncementNotification::class);
});
