<?php

use App\Models\User;
use function Pest\Laravel\assertAuthenticated;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('verifies if a guest can access to login page', function () {
    // Act
    $response = $this->get(route('login'));

    // Assert
    $response->assertStatus(200);
});


it('check if a route to access a login form existe', function () {
    // Act
    $response = get(route('login'));

    // Assert
    $response->assertStatus(200);
    $response->assertSeeHtml(
        '<form method="POST" '.'action="'.
        route('login')
    );
    $response->assertSee('Login');
    $response->assertSeeHtmlInOrder([
        '<input type="email"',
        '<input type="password"',
        '<button type="submit"',
    ]);
});

it('requires email field', function () {
    // Act
    $response = post(route('login'), [
        'password' => 'change_this',
    ]);

    // Assert
    $response->assertSessionHasErrors('email');
});

it('requires password field', function () {
    // Act
    $response = post(route('login'), [
        'email' => 'mohamed@lefilrouge.com',
    ]);

    // Assert
    $response->assertSessionHasErrors('password');
});

it('fails to login with email not existe', function () {
    // Act
    $response = post(route('login'), [
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
    $response = post(route('login'), [
        'email'    => $user->email,
        'password' => 'change_this',
    ]);

    // Assert
    assertAuthenticated(config('fortify.guard'));
    $response->assertRedirect(config('fortify.home'));
    $this->assertAuthenticatedAs($user);
});
