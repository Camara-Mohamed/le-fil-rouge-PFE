<?php

use App\Models\User;

use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('verifies if a guest can access to login page', function () {
    // Act
    $response = $this->get(route('login', ['locale'=>app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
});

it('check if a route to access a login form existe', function () {
    // Act
    $response = get(route('login', ['locale'=>app()->getLocale()]));

    // Assert
    $response->assertStatus(200);
    $response->assertSeeHtml(
        '<form method="POST" '.'action="'.
        route('login', ['locale'=>app()->getLocale()])
    );
    $response->assertSee(__('auth.login.title'));
    $response->assertSee('type="email"', false);
    $response->assertSee('name="password"', false);
});

it('requires email field', function () {
    // Act
    $response = post(route('login', ['locale'=>app()->getLocale()]), [
        'password' => 'change_this',
    ]);

    // Assert
    $response->assertSessionHasErrors('email');
});

it('requires password field', function () {
    // Act
    $response = post(route('login', ['locale'=>app()->getLocale()]), [
        'email' => 'mohamed@lefilrouge.com',
    ]);

    // Assert
    $response->assertSessionHasErrors('password');
});

it('fails to login with email not existe', function () {
    // Act
    $response = post(route('login', ['locale'=>app()->getLocale()]), [
        'email' => 'alex@lefilrouge.com',
        'password' => 'change_this',
    ]);

    // Assert
    $response->assertSessionHasErrors();
    $this->assertGuest();
});

it('redirects a successfully authenticated user to the predefined home page', function () {
    // Arrange
    $user = User::factory()->create([
        'email' => 'bruno@lefilrouge.com',
        'password' => 'change_this',
    ]);

    // Act
    $response = post(route('login', ['locale'=>app()->getLocale()]), [
        'email' => $user->email,
        'password' => 'change_this',
    ]);

    // Assert
    assertAuthenticated(config('fortify.guard'));
    $response->assertRedirect(config('fortify.home'));
    $this->assertAuthenticatedAs($user);
});
