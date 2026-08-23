<?php

use App\Enums\CampStatus;
use App\Enums\TrainingStatus;
use App\Enums\UserRoles;
use App\Enums\UserStatus;
use App\Models\Camp;
use App\Models\Training;
use App\Models\User;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => UserRoles::ADMIN,
        'status' => UserStatus::COMPLETE,
    ]);

    $this->member = User::factory()->create([
        'role' => UserRoles::ANIMATEUR_1,
        'status' => UserStatus::COMPLETE,
    ]);
});

it('unauthenticated user is redirected to login when accessing dashboard', function () {
    visit('/fr/dashboard')
        ->assertPathIs('/fr/login');
});

it('login with wrong credentials shows an error message', function () {
    visit('/fr/login')
        ->type('email', 'inconnu@example.com')
        ->type('password', 'mauvais_mot_de_passe')
        ->press('Se connecter')
        ->assertSee('Ces identifiants ne correspondent');
});

it('authenticated member can access their profile page', function () {
    actingAs($this->member);

    visit(route('admin.profile', ['locale' => 'fr']))
        ->assertSee('Profil');
});

it('authenticated member can access their enrollment history page', function () {
    actingAs($this->member);

    visit(route('admin.enrollments', ['locale' => 'fr']))
        ->assertSee('Mon Historique');
});

it('admin can access the members management page', function () {
    actingAs($this->admin);

    visit(route('admin.members.index', ['locale' => 'fr']))
        ->assertSee('Les membres');
});

it('published camp detail page displays the camp title', function () {
    $camp = Camp::factory()->create([
        'title' => 'Stage Animateur Test Browser',
        'status' => CampStatus::PUBLISHED,
        'user_id' => $this->admin->id,
    ]);

    visit(route('public.camps.show', ['locale' => 'fr', 'camp' => $camp]))
        ->assertSee('Stage Animateur Test Browser');
});

it('published training detail page displays the training title', function () {
    $training = Training::factory()->create([
        'title' => 'Formation Premiers Secours Test Browser',
        'status' => TrainingStatus::PUBLISHED,
        'user_id' => $this->admin->id,
    ]);

    visit(route('public.trainings.show', ['locale' => 'fr', 'training' => $training]))
        ->assertSee('Formation Premiers Secours Test Browser');
});
