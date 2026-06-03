<?php

it('home page renders with title and nav links', function () {
    $page = visit('/fr');

    $page->assertSee('Page d\'Accueil');
});

it('navigates to trainings page from nav', function () {
    $page = visit('/fr');

    $page->click('Les Formations')
        ->assertSee('Liste des formations');
});

it('navigates to camps page from nav', function () {
    $page = visit('/fr');

    $page->click('Les Camps')
        ->assertSee('La liste des stages et séjours');
});

it('navigates to announcements page from nav', function () {
    $page = visit('/fr');

    $page->click('Les Actualités')
        ->assertSee('Liste des actualités');
});

it('navigates to about page from nav', function () {
    $page = visit('/fr');

    $page->click('Qui sommes-nous')
        ->assertSee('Qui sommes-nous ?');
});

it('navigates to contact page from nav', function () {
    $page = visit('/fr');

    $page->click('Nous Contacter')
        ->assertSee('Nous Contacter');
});

it('contact page has all form fields', function () {
    $page = visit('/fr/contact');

    $page->assertPresent('input[name=full_name]')
        ->assertPresent('input[name=email]')
        ->assertPresent('input[name=sujet]')
        ->assertPresent('textarea[name=message]')
        ->assertSee('Envoyer');
});

it('volunteer page has the form', function () {
    $page = visit(route('public.volunteer', ['locale' => 'fr']));

    $page->assertPresent('input[name=first_name]')
        ->assertPresent('input[name=last_name]')
        ->assertPresent('input[name=email]')
        ->assertSee('Envoyer');
});

it('nav login link goes to login page', function () {
    $page = visit('/fr');

    $page->click('Login')
        ->assertPathIs('/fr/login')
        ->assertSee('Connexion');
});

it('language switch changes locale', function () {
    $page = visit('/fr');

    $page->assertSee('Page d\'Accueil');

    $page->click('[href*="/en"]')
        ->assertPathBeginsWith('/en');
});
