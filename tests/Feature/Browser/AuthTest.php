<?php

use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->user = User::factory()->create([
        'email' => 'mohamed.camara@lefilrouge.com',
        'password' => bcrypt('change_this'),
    ]);
});

it('login page renders with all form fields', function () {
    $page = visit('/fr/login');

    $page->assertSee('Connexion')
        ->assertPresent('input[name=email]')
        ->assertPresent('input[name=password]')
        ->assertSee('Se connecter')
        ->assertSee('Mot de passe oublié ?');
});

it('login page has link back to home page', function () {
    $page = visit('/fr/login');

    $page->assertSeeLink('Revenir à la page d\'accueil');
});

it('authenticated user can access dashboard', function () {
    actingAs($this->user);

    visit('/dashboard')
        ->assertSee('Dashboard');

    $this->user->forceDelete();
});

it('user can logout', function () {
    actingAs($this->user);

    visit(route('admin.dashboard', ['locale' => 'fr']))
        ->click('Mon Profil')
        ->click('Logout')
        ->assertSee('Login');

    $this->user->forceDelete();
});
