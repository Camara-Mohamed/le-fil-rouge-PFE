<?php

use App\Enums\UserRoles;
use App\Models\User;

it('returns the user full name', function () {
    $user = User::factory()->make([
        'first_name' => 'Mohamed',
        'last_name' => 'Camara',
    ]);

    expect($user->fullName())->toBe('Mohamed Camara');
});

it('returns that user is admin', function () {
    $user = User::factory()->make(['role' => UserRoles::ADMIN]);

    expect($user->isAdmin())->toBeTrue();
});

it('returns that user is not admin', function () {
    $user = User::factory()->make(['role' => UserRoles::ARRIVANT]);

    expect($user->isAdmin())->toBeFalse();
});

it('returns user roles', function () {
    expect(User::factory()->make(['role' => UserRoles::FORMATEUR])->isFormateur())->toBeTrue()
        ->and(User::factory()->make(['role' => UserRoles::COORDINATEUR])->isCoordinateur())->toBeTrue()
        ->and(User::factory()->make(['role' => UserRoles::ANIMATEUR_1])->isAnimateur1())->toBeTrue()
        ->and(User::factory()->make(['role' => UserRoles::ANIMATEUR_2])->isAnimateur2())->toBeTrue()
        ->and(User::factory()->make(['role' => UserRoles::BREVETE])->isBrevete())->toBeTrue()
        ->and(User::factory()->make(['role' => UserRoles::ARRIVANT])->isArrivant())->toBeTrue();
});

it('get the user formatted age', function () {
    $user = User::factory()->make([
        'birth_date' => now()->subYears(25)->toDateString(),
    ]);

    expect($user->getAge())->toBe(25);
});
